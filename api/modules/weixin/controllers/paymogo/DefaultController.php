<?php

namespace api\modules\weixin\controllers\paymogo;

use api\modules\weixin\controllers\common\BaseController;

class DefaultController extends  BaseController {
    public function actionIndex(){
        if(array_key_exists('echostr',$_GET) && $_GET['echostr']){//用于微信第一次认证的
            echo $_GET['echostr'];exit();
        }

		$xml_data = file_get_contents("php://input");
        file_put_contents( "/tmp/mogo.log",$xml_data,FILE_APPEND );

        return "success";
    }

} 