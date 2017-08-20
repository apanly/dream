<?php

namespace blog\controllers;
use common\components\UtilHelper;
use common\models\oauth\OauthBind;
use common\models\user\Member;
use common\models\weixin\OauthMember;
use common\service\captcha\ValidateCode;
use blog\controllers\common\BaseController;
use common\service\CityService;
use common\service\Constant;
use common\service\GlobalUrlService;
use common\service\oauth\ClientService;
use Yii;


class UserController extends BaseController{

	public function __construct($id, $module, $config = []){
		parent::__construct($id, $module, $config = []);
		$this->layout = "user";
	}

	public function actionLogin(){
		$url = $this->getReferer();

		if( Yii::$app->request->isGet ) {
			$this->setTitle("登录");
			$this->setReferer();
			$is_login = $this->checkMemberLoginStatus();
			if( $is_login ){
				return $this->redirect( $url );
			}
			return $this->render("login");
		}

		$login_name = trim( $this->post("login_name","") );
		$login_pwd = trim( $this->post("login_pwd","") );
		$date_now = date("Y-m-d H:i:s");

		if( mb_strlen( $login_name,"utf-8" ) < 1 ){
			return $this->renderJSON( [] , "请输入符合规范的登录邮箱或者登录名~~" ,-1);
		}

		if( mb_strlen( $login_pwd,"utf-8" ) < 6 ){
			return $this->renderJSON( [] , "请设置一个不少于6位的密码~~" ,-1);
		}

		if( filter_var( $login_name ,FILTER_VALIDATE_EMAIL) ){
			$member_info = Member::find()->where([ 'email' => $login_name ])->one();
		}else{
			$member_info = Member::find()->where([ 'login_name' => $login_name ])->one();
		}

		if( !$member_info ){
			return $this->renderJSON([],"请输入正确的登录用户名和密码-1~~",-1);
		}

		if( !$member_info->verifyPassword( $login_pwd ) ){
			return $this->renderJSON([],"请输入正确的登录用户名和密码-2~~",-1);
		}

		$member_info->last_ip = UtilHelper::getClientIP();
		$member_info->last_city = CityService::getCityNameByIp( $member_info->last_ip );
		$member_info->last_city_id = CityService::getCityIdByIP( $member_info->last_ip );
		$member_info->last_active_time = $date_now;
		$member_info->updated_time = $date_now;
		$member_info->update( 0 );


		$this->createMemberLoginStatus( $member_info );
		return $this->renderJSON( [ 'url' => $url ],"登录成功~~" );
	}

	public function actionReg(){
		if( Yii::$app->request->isGet ){
			$this->setTitle("注册");
			$get_referer = $this->get( "referer","" );
			if( $get_referer ){
				$this->setReferer();
			}

			return $this->render( "reg" );
		}

		$login_name = trim( $this->post("login_name","") );
		$email = trim( $this->post("email","") );
		$login_pwd = trim( $this->post("login_pwd","") );
		$captcha_code = trim( $this->post("captcha_code","") );
		$date_now  = date("Y-m-d H:i:s");

		if( mb_strlen( $login_name,"utf-8" ) < 1 ){
			return $this->renderJSON( [] , "请输入符合规范的登录名~~" ,-1);
		}

		if( mb_strlen( $email,"utf-8" ) < 1 ){
			return $this->renderJSON( [] , "请输入符合规范的邮箱地址~~" ,-1);
		}


		if( mb_strlen( $login_pwd,"utf-8" ) < 6 ){
			return $this->renderJSON( [] , "请设置一个不少于6位的密码~~" ,-1);
		}

		if( in_array( $login_pwd,Constant::$low_password ) ){
			return $this->renderJSON( [] , "登录密码太简单，请换一个~~" ,-1);
		}

		if( !$this->checkCaptcha(  $captcha_code ) ){
			return $this->renderJSON( [] , "请输入正确的验证码~~" ,-1);
		}

		$has_in = Member::find()->where([ 'login_name' => $login_name ])->count();
		if( $has_in ){
			return $this->renderJSON( [] , "该登录名已存在，请换一个试试~~" ,-1);
		}

		$has_in = Member::find()->where([ 'email' => $email ])->count();
		if( $has_in ){
			return $this->renderJSON( [] , "该邮箱已存在，请换一个试试~~" ,-1);
		}
		
		$model_member = new Member();
		$model_member->login_name = $login_name;
		$model_member->email = $email;
		$model_member->setSalt();
		$model_member->setPassword( $login_pwd );
		$model_member->avatar = Constant::$default_avatar;

		$model_member->last_ip = UtilHelper::getClientIP();
		$model_member->last_city = CityService::getCityNameByIp( $model_member->last_ip );
		$model_member->last_city_id = CityService::getCityIdByIP( $model_member->last_ip );
		$model_member->last_active_time = $date_now;

		$model_member->reg_ip = $model_member->last_ip;
		$model_member->reg_city = $model_member->last_city;
		$model_member->reg_city_id = $model_member->last_city_id;
		$model_member->updated_time = $date_now;
		$model_member->created_time = $date_now;
		$model_member->save( 0 );
		return $this->renderJSON( [],"注册成功~~");
	}

	public function actionForget(){
		return $this->render( "forget" );
	}

	public function actionLogout(){
		$this->setReferer();
		$this->removeMemberAuthToken();
		return $this->redirect( $this->getReferer() );
	}

	public function actionOauth(){
		$type = trim( $this->get("type",'weibo') );
		$url = ClientService::goLogin( $type,GlobalUrlService::buildBlogUrl("/user/oauth_weibo") );
		return $this->redirect( $url );
	}

	/*
	 * 回调地址
	 * */
	public function actionOauth_weibo(){
		$type = "weibo";
		$ret = ClientService::getAccessToken( $type,$this->get( null ) );
		$error_msg = '';
		$uid = 0;
		if( $ret ){
			$uid = $this->getUserInfo( $type, $ret['access_token'],[ 'uid' => $ret['uid'] ] );
		}else{
			$error_msg = ClientService::getLastErrorMsg();
		}

		return $this->redirect( GlobalUrlService::buildBlogUrl("/oauth/login",[
			'error_msg' => $error_msg,
			'uid' => $uid,
			'type' => $type
		]) );
	}

	private function getUserInfo( $type,$access_token,$params = [] ){
		$ret = ClientService::getUserInfo( $type,$access_token ,$params );
		if( !$ret ){
			return ClientService::_err( "获取用户信息失败" );
		}

		//判断是否已经绑定
		$date_now = date("Y-m-d H:i:s");
		$has_bind = OauthBind::find()->where([ 'client_type' => $type,'openid' => $ret['openid'] ])->one();
		$member_id = ( $has_bind && $has_bind['member_id'] )?$has_bind['member_id']:0;
		if( !$member_id ){
			if( $has_bind ){

			}else{

			}
		}

		if( $has_bind && $has_bind['member_id']){
			$uid = $has_bind['member_id'];
		}else{//新建用户并绑定关系
			$date_now = date("Y-m-d H:i:s");
			$unique_name = md5( $type."_".$ret['name'] );
			$user_info = Member::findOne([ 'unique_name' => $unique_name  ]);
			if( !$user_info ){
				$model_user = new User();
				$model_user->nickname = $ret['name'];
				$model_user->unique_name = $unique_name;
				$model_user->avatar = $ret['avatar'];
				$model_user->updated_time = $model_user->created_time = $date_now;
				if( !$model_user->save( 0 ) ){
					return ClientService::_err( "获取用户信息失败" );
				}
				$user_info = $model_user;
			}

			$model_auth_bind = new OauthBind();
			$model_auth_bind->uid = $user_info->uid;
			$model_auth_bind->client_type = $type;
			$model_auth_bind->openid = $ret['openid'];
			$model_auth_bind->extra = json_encode( $ret );
			$model_auth_bind->created_time = $date_now;
			$model_auth_bind->save( 0 );
			$uid = $user_info->uid;
		}

		return $uid;
	}


	private $captcha_cookie_name = "validate_code";

	public function actionImg_captcha(){
		$font_path = \Yii::$app->getBasePath().'/web/fonts/captcha.ttf';
		$captcha_handle = new ValidateCode( $font_path );
		$captcha_handle->doimg();
		$this->setCookie($this->captcha_cookie_name,$captcha_handle->getCode() );
	}

	private function checkCaptcha( $captcha_code ){
		$cookie_captcha = $this->getCookie( $this->captcha_cookie_name,"" );
		if( strtolower( $cookie_captcha ) != strtolower( $captcha_code ) ){
			return false;
		}
		return true;
	}

	private $referer_cookie_name = "referer";

	private function setReferer(){
		$cookie_referer = $this->getCookie( $this->referer_cookie_name,"" );
		$get_referer = $this->get( "referer","" );
		if( !$get_referer ){
			if( $cookie_referer ){
				$get_referer = $cookie_referer;
			}else{
				$get_referer = $_SERVER['HTTP_REFERER'];
			}
		}else{
			$get_referer = GlobalUrlService::buildUrl( urldecode( $get_referer ) );
		}

		if( $get_referer && $get_referer != $cookie_referer ){
			$this->setCookie( $this->referer_cookie_name,$get_referer,3600 );
		}
	}

	private function getReferer(){
		$cookie_referer = $this->getCookie( $this->referer_cookie_name,"" );
		$get_referer = urldecode( $this->get( "referer","" ) );
		$final_referer = ( $get_referer && $get_referer != $cookie_referer )?$get_referer:$cookie_referer;
		if( !$cookie_referer && !$get_referer){
			$final_referer = GlobalUrlService::buildSuperMarketUrl( "/" );
		}
		return $final_referer;
	}

}