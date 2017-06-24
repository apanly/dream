<?php
namespace weixin\controllers;

use common\service\weixin\WechatConfigService;
use Yii;
use yii\log\FileTarget;

class BaseController extends \common\components\BaseWebController{

    public function beforeAction($action) {
        $this->layout = false;
        return true;
    }

    public function checkSignature(){
    	$signature = trim( $this->get("signature","") );
    	$timestamp = trim( $this->get("timestamp","") );
    	$nonce = trim( $this->get("nonce","") );
		$config = WechatConfigService::getConfig();
		$tmpArr = array( $config['apptoken'], $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
    }

    public   function record_log($msg){
        $log = new FileTarget();
        $log->logFile = Yii::$app->getRuntimePath() . "/logs/weixin_msg_".date("Ymd").".log";
        $request_uri = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'';
        $log->messages[] = [
            "[url:{$request_uri}][post:".http_build_query($_POST)."] [msg:{$msg}]",
            1,
            'application',
            microtime(true)
        ];
        $log->export();
    }
}