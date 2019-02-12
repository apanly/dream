<?php
namespace weixin\controllers;

use \common\service\weixin\RequestService;
use Yii;

class JssdkController extends BaseController {

    public function actionIndex(){
        $this->setWeixinConfig();
        return $this->renderJSON($this->getSignPackage());
    }

    public function actionToken(){
		$this->setWeixinConfig();
		return $this->renderJSON( [ 'data' => RequestService::getAccessToken() ] );
	}

    private function getSignPackage() {
        $jsapiTicket = $this->getJsApiTicket();
        if( $jsapiTicket == 40001){
            $jsapiTicket = $this->getJsApiTicket(true);
        }
        $url = trim(Yii::$app->request->get("url"));
        if( !$url ){
            $url = isset( $_SERVER['HTTP_REFERER'] )?$_SERVER['HTTP_REFERER']:'';
        }

        $timestamp = time();
        $nonceStr = $this->createNonceStr();
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);
        $signPackage = array(
            "appId"     => RequestService::getAppId(),
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            //"string" => $string
        );
        return $signPackage;
    }

    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }


    private function getJsApiTicket( $force = false) {
        $cache_key = 'wx_js_tkt_'.substr( RequestService::getAppId() ,2);
		$cache = Yii::$app->cache;
		$ticket = $cache->get($cache_key);

        if ( !$ticket || $force ) {
            $accessToken = RequestService::getAccessToken();
            $url = "ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = RequestService::send($url);
            $ticket_info = $res;
            if( isset($ticket_info['errcode'])  && $ticket_info['errcode'] != 0 ){
                return $ticket_info['errcode'];
            }

            $ticket = isset( $ticket_info['ticket'] )? $ticket_info['ticket']:'';

            if ($ticket) {
				$cache->set($cache_key,$ticket,$ticket_info['expires_in'] - 200 );
            }

        }
        return $ticket;
    }

    private function setWeixinConfig(){
		$config = \Yii::$app->params['weixin'];
		RequestService::setConfig( $config['appid'],$config['token'],$config['sk'] );
    }

    protected function renderJSON($data=[], $msg ="ok", $code = 200){
        header('Content-type: application/json');
        echo json_encode([
            "code" => $code,
            "msg"   =>  $msg,
            "data"  =>  $data,
            "req_id" =>  uniqid(),
        ]);
        return Yii::$app->end();
    }

}
