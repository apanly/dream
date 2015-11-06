<?php

namespace admin\controllers;

use admin\controllers\common\BaseController;
use Yii;
use common\models\user\Admin;

class AuthController extends BaseController
{

    public function actionIndex(){
        $this->layout = false;
        return $this->render("index",[
            "copyright" => Yii::$app->params['Copyright']
        ]);
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
        if(!$user_info){
            return $this->renderJSON([],"请输入正确的手机号码和密码!",-1);
        }

        if(!$user_info->ckeckPassword($passwd)){
            return $this->renderJSON([],"请输入正确的手机号码和密码!",-1);
        }

        $this->createLoginStatus($user_info);
        return $this->renderJSON(['url' => "/"]);
    }

    public function actionLoginout(){
        $this->removeAuthToken();
        return $this->goHome();
    }

}