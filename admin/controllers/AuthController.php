<?php

namespace admin\controllers;

use admin\components\AccessLogService;
use admin\controllers\common\BaseController;
use Yii;
use common\models\user\Admin;

class AuthController extends BaseController{

    public function actionIndex(){
    	$this->layout = "auth";
        return $this->render("index");
    }

    public function actionLogin(){
        $request  = Yii::$app->request;
        if($request->isGet){
            return $this->renderJSON([],"请使用POST提交",-1);
        }
        $mobile = trim($this->post("mobile"));
        $passwd = trim($this->post("passwd"));

        if(!preg_match("/^[1-9]\d{10}$/",$mobile)){
            return $this->renderJSON([],"请输入符合规范的手机号码!",-1);
        }

        $user_info = Admin::findOne(['mobile' => $mobile]);
        $params = [
            'target_type' => 1,
            'target_id' => 0,
            'act_type' => 1,
            'status' => 0,
            'login_name' => $mobile
        ];

        if(!$user_info){
            AccessLogService::recordAccess_log( $params );
            return $this->renderJSON([],"请输入正确的手机号码和密码!",-1);
        }

        if(!$user_info->ckeckPassword($passwd)){
            AccessLogService::recordAccess_log( $params );
            return $this->renderJSON([],"请输入正确的手机号码和密码!",-1);
        }
        
        $params['status'] = 1;
        AccessLogService::recordAccess_log( $params );
        $this->createLoginStatus($user_info);
        return $this->renderJSON(['url' => "/"]);
    }

    public function actionLoginout(){
        $this->removeAuthToken();
        return $this->goHome();
    }

}