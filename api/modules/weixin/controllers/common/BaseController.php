<?php
namespace api\modules\weixin\controllers\common;

use api\modules\weixin\controllers\WxrequestController;
use Yii;
use yii\log\FileTarget;

class BaseController extends \yii\web\Controller
{

    public function beforeAction($action) {
         return true;
    }


    protected function geneReqId(){
        return uniqid();
    }

    public function checkSignature(){
        $request = Yii::$app->request;
        $signature = $request->get("signature");
        $timestamp = $request->get("timestamp");
        $nonce = $request->get("nonce");
        $token = WxrequestController::$token;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    public function recode_log($msg){
        $log = new FileTarget();
        $log->logFile = Yii::$app->getRuntimePath() . '/logs/wx_debug.log';
        $log->messages[] = [
            $msg ,
            1,
            'application',
            microtime(true)
        ];
        $log->export();
    }
}