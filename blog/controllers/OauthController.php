<?php
namespace blog\controllers;

use blog\controllers\common\BaseController;
use common\service\oauth\ClientService;

/**
 * 专门集成第三方登录
 */
class OauthController extends BaseController{

	/*
	 * 登录
	 * */
	public function actionLogin(){

		$oauth_type = [ 'weibo','github' ];
		$auth_urls = [];
		foreach ( $oauth_type as $_type ){
			$auth_urls[] = [
				'type' => $_type,
				'url' => ClientService::goLogin( $_type )
			];
		}
		return $this->render("login",[
			"auth_urls" => $auth_urls,
		]);

	}

	/*
	 * 回调地址
	 * */
	public function actionWeibo(){
		$ret = ClientService::getAccessToken( "weibo",$this->get( null ) );
		if( !$ret ){
			return $this->render("error",[
				'error_msg' => ClientService::getLastErrorMsg()
			]);
		}
		return $this->render("login",[
			'user_info' => []
		]);
	}

	public function actionGithub(){
		$ret = ClientService::getAccessToken( "github",$this->get( null ) );

	}


	private function getUserInfo( $type,$access_token ){

	}


}