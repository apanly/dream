<?php
namespace blog\controllers;

use blog\components\UrlService;
use blog\controllers\common\BaseController;
use common\models\oauth\OauthBind;
use common\models\user\User;
use common\service\GlobalUrlService;
use common\service\oauth\ClientService;

/**
 * 专门集成第三方登录
 */
class OauthController extends BaseController{

	/*
	 * 登录
	 * */
	public function actionLogin(){
		$uid = intval( $this->get("uid",0) );
		$type = trim( $this->get("type",'') );
		$user_info = [];
		if( $uid ){
			$user_info = User::findOne([ 'uid' => $uid ]);
		}

		$oauth_type = [
			'weibo' => '新浪微博',
			'github' => 'Github',
			'qq' => '腾讯qq'
		];
		$auth_urls = [];
		foreach ( $oauth_type as $_type => $_title ){
			$auth_urls[] = [
				'type' => $_type,
				'title' => $_title,
				'url' => ClientService::goLogin( $_type )
			];
		}



		return $this->render("login",[
			"auth_urls" => $auth_urls,
			"error_msg" => trim( $this->get( "error_msg","" ) ),
			"user_info" => $user_info,
			'type' => isset( $oauth_type[ $type ] )?$oauth_type[ $type ]:''
		]);

	}

	/*
	 * 回调地址
	 * */
	public function actionWeibo(){
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

	public function actionGithub(){
		$type = "github";
		$ret = ClientService::getAccessToken( $type,$this->get( null ) );
		$error_msg = '';
		$uid = 0;
		if( $ret ){
			$uid = $this->getUserInfo( $type, $ret['access_token'] );
		}else{
			$error_msg = ClientService::getLastErrorMsg();
		}

		return $this->redirect( GlobalUrlService::buildBlogUrl("/oauth/login",[
			'error_msg' => $error_msg,
			'uid' => $uid,
			'type' => $type
		]) );
	}

	public function actionQq(){
		$type = "qq";
		$ret = ClientService::getAccessToken( $type,$this->get( null ) );
		if( !$ret ){

		}
		$error_msg = '';
		$uid  = 0;
		if( $ret ){
			$uid = $this->getUserInfo( $type, $ret['access_token'] );
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
			return false;
		}
		//判断是否已经绑定
		$has_bind = OauthBind::find()->where([ 'client_type' => $type,'openid' => $ret['openid'] ])->one();

		if( $has_bind ){
			$uid = $has_bind['uid'];
		}else{//新建用户并绑定关系
			$date_now = date("Y-m-d H:i:s");
			$unique_name = md5( $type."_".$ret['name'] );
			$user_info = User::findOne([ 'unique_name' => $unique_name  ]);
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

}