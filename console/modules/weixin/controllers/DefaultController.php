<?php

namespace console\modules\weixin\controllers;

use common\components\HttpClient;
use common\service\weixin\RequestService;
use common\service\weixin\WechatConfigService;
use common\service\weixin\WxQueueListService;

class DefaultController extends BaseController {
    public function actionIndex(){
       echo 'index';
    }

    public function actionFixMember(){
    	$config = WechatConfigService::getConfig();
		RequestService::setConfig( $config['appid'],$config['apptoken'],$config['appsecret'] );
		$access_token = RequestService::getAccessToken();
    	$url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token={$access_token}";
    	$data = HttpClient::get( $url );
    	$data = @json_decode( $data,true );
    	if( !$data || !isset( $data['data'] ) || !isset( $data['data']['openid']) ){
    		return $this->echoLog( "no list" );
		}

		foreach ( $data['data']['openid'] as $_openid ){
			WxQueueListService::addQueue( "info",[ "openid" => $_openid ] );
		}

		return $this->echoLog( "it's over ~~" );
	}
}
