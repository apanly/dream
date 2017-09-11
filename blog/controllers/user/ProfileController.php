<?php

namespace blog\controllers\user;


use blog\controllers\common\BaseController;
use common\service\Constant;

use Yii;


class ProfileController extends BaseController{

	public function __construct($id, $module, $config = []){
		parent::__construct($id, $module, $config = []);
		$this->layout = "user";
	}


	public function actionIndex(){
		return $this->render("index");
	}

	public function actionSetPwd(){
		if( \Yii::$app->request->isGet ){
			return $this->render("set_pwd");
		}

		$pwd = trim( $this->post( "pwd","" ) );
		$pwd1 = trim( $this->post( "pwd1","" ) );
		$pwd2 = trim( $this->post( "pwd2","" ) );

		if( mb_strlen( $pwd,"utf-8" ) < 1 ){
			return $this->renderJSON( [] , "请输入当前账号密码~~" ,-1);
		}

		if( mb_strlen( $pwd1,"utf-8" ) < 6 ){
			return $this->renderJSON( [] , "请设置一个不少于6位的新密码~~" ,-1);
		}

		if( in_array( $pwd1,Constant::$low_password ) ){
			return $this->renderJSON( [] , "登录密码太简单，请换一个~~" ,-1);
		}

		if( $pwd1 != $pwd2 ){
			return $this->renderJSON( [] , "请输入确认密码，确认密码必须与新密码一致~~" ,-1);
		}

		$current_member_info = $this->current_member;
		if( !$current_member_info->verifyPassword( $pwd ) ){
			return $this->renderJSON([],"当前账号密码输入不对，请重新输入~~",-1);
		}

		$current_member_info->setPassword( $pwd1 );
		$current_member_info->updated_time = date("Y-m-d H:i:s");
		$current_member_info->update( 0 );
		$current_member_info->refresh();

		$this->createMemberLoginStatus( $current_member_info );

		return $this->renderJSON( [],"操作成功~~" );

	}

	public function actionNotice(){
		return $this->render("notice");
	}

	public function actionBind(){
		return $this->render("bind");
	}

}