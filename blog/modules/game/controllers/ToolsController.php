<?php

namespace blog\modules\game\controllers;

use blog\modules\game\controllers\common\BaseController;

class ToolsController extends BaseController
{
    public function actionIndex(){
        $request = \Yii::$app->request;
        if( $request->isGet ){
            $this->setTitle("在线密码生成器");
            $this->setSubTitle("在线密码生成器");
            return $this->render("index");
        }

        $s_options = $this->post("options",[]);
        $pass_length = intval($this->post("pass_length",16));
        if( count($s_options) < 1 ){
            return $this->renderJSON([],"请选择所用字符!",-1);
        }

        return $this->renderJSON([
            "pwd" => $this->gene_password($s_options,$pass_length)
        ]);
    }

    public function actionStrlen(){
        $this->setTitle("字符串长度计算器");
        $this->setSubTitle("字符串长度计算器");
        return $this->render("strlen");
    }

    private function gene_password( $s_options,$length = 16 ) {
        $options = [
            1 => "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
            2 => "!@#$%^&*"
        ];
        $chars = "";
        foreach( $s_options as $_option ){
            $chars .= $options[$_option];
        }

        $password = '';
        for ( $i = 0; $i < $length; $i++ ){
            $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }

        return $password;
    }
} 