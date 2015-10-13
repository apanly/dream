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

    public static function post($key, $default = "") {
        return Yii::$app->request->post($key, $default);
    }


    public static function get($key, $default = "") {
        return Yii::$app->request->get($key, $default);
    }


    public function checkSignature(){
        $signature = $this->get("signature");
        $timestamp = $this->get("timestamp");
        $nonce = $this->get("nonce");
        $token = WxrequestController::getAppToken();
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

    protected  static function getSource(){
        return self::get("from","imguowei_888");
    }

    public function recode_log($msg){
        $log = new FileTarget();
        $log->logFile = Yii::$app->getRuntimePath() . '/logs/wx_debug_'.date("Y-m-d").'.log';
        $log->messages[] = [
            $msg ,
            1,
            'application',
            microtime(true)
        ];
        $log->export();
    }
}