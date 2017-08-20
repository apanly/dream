<?php

namespace blog\controllers;
use common\components\UtilHelper;
use common\models\user\Member;
use common\service\captcha\ValidateCode;
use blog\controllers\common\BaseController;
use common\service\CityService;
use common\service\Constant;
use common\service\GlobalUrlService;
use Yii;


class UserController extends BaseController{

	public function __construct($id, $module, $config = []){
		parent::__construct($id, $module, $config = []);
		$this->layout = "user";
	}

	public function actionLogin(){
		$url = GlobalUrlService::buildSuperMarketUrl( "/" );

		if( Yii::$app->request->isGet ) {
			$this->setTitle("登录");
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
			return $this->renderJSON([],"请输入正确的登录用户名和密码-2~~".$member_info->getSaltPassword( $login_pwd ),-1);
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
		$this->removeMemberAuthToken();
		return $this->redirect( GlobalUrlService::buildSuperMarketUrl("/") );
	}

	public function actionOauth(){

	}

	private $captcha_cookie_name = "validate_code";

	public function actionImg_captcha(){
		$font_path = \Yii::$app->getBasePath().'/web/fonts/captcha.ttf';
		$captcha_handle = new ValidateCode( $font_path );
		$captcha_handle->doimg();
		$this->setCookie($this->captcha_cookie_name,$captcha_handle->getCode() );
	}

}