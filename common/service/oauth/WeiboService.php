<?php


namespace common\service\oauth;


use common\components\HttpClient;

class WeiboService extends  ClientBase {
	public function Login(){
		$url = "https://api.weibo.com/oauth2/authorize";
		$config_params = \Yii::$app->params;
		$params = [
			'client_id' => $config_params['oauth']['weibo']['ak'],
			'redirect_uri' => $this->getCallback()
		];
		return $url."?".http_build_query( $params );
	}

	public function getAccessToken( $params = [] ){
		$config = \Yii::$app->params['oauth']['weibo'];
		$post_params = [
			'client_id' => $config['ak'],
			'client_secret' => $config['as'],
			'grant_type' => 'authorization_code',
			'code' => isset( $params['code'] )?$params['code']:'',
			'redirect_uri' => $this->getCallback()
		];
		$url = "https://api.weibo.com/oauth2/access_token";
		$ret = HttpClient::post( $url,$post_params );
		$ret = @json_decode( $ret,true );
		if( !$ret || isset( $ret['error'] ) ){
			return $this->_err( $ret['error'] );
		}
		return $ret;
	}

	public function getUserInfo( $access_token,$params = [] ){
		$config = \Yii::$app->params['oauth']['weibo'];
		$url = "https://api.weibo.com/2/users/show.json";
		$get_params = [
			'access_token' => $access_token,
			'uid' => isset( $params['uid'] )?$params['uid']:0,
			'appkey' => $config['ak']
		];
		$ret = HttpClient::get( $url."?".http_build_query( $get_params ) );
		return $ret;
	}

	private  function getCallback(){
		$callback = \Yii::$app->params['oauth']['weibo']['callback'];
		return "http://www.vincentguo.cn".$callback;
	}
}