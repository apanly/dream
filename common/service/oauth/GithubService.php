<?php


namespace common\service\oauth;


use common\components\HttpClient;

class GithubService extends  ClientBase {
	public function Login(){
		$url = "https://github.com/login/oauth/authorize";
		$config_params = \Yii::$app->params;
		$params = [
			'client_id' => $config_params['oauth']['github']['ak'],
			'redirect_uri' => $this->getCallback()
		];
		return $url."?".http_build_query( $params );
	}

	public function getAccessToken( $params = [] ){
		$config = \Yii::$app->params['oauth']['github'];
		$post_params = [
			'client_id' => $config['ak'],
			'client_secret' => $config['as'],
			'code' => isset( $params['code'] )?$params['code']:'',
			'redirect_uri' => $this->getCallback()
		];
		$url = "https://github.com/login/oauth/access_token";
		HttpClient::setHeader([ 'Accept' => 'application/json' ]);
		$ret = HttpClient::post( $url,$post_params );
		$ret = @json_decode( $ret,true );
		if( !$ret || isset( $ret['error'] ) ){
			return $this->_err( $ret['error'] );
		}
		return $ret;
	}

	public function getUserInfo( $access_token,$params = [] ){
		$url = "https://api.github.com/user";
		HttpClient::setHeader([ 'Authorization' => "token {$access_token}" ]);
		$ret = HttpClient::get( $url );
		$ret = @json_decode( $ret,true );
		if( !$ret || isset( $ret['error'] ) ){
			return $this->_err( $ret['error'] );
		}
		$ret['openid'] = $ret['id'];
		$ret['avatar'] = $ret['avatar_url'];
		return $ret;
	}

	private  function getCallback(){
		$callback = \Yii::$app->params['oauth']['github']['callback'];
		return "http://www.vincentguo.cn".$callback;
	}
}