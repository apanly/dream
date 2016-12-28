<?php


namespace common\service\oauth;


use common\components\HttpClient;

class QqService extends  ClientBase {
	public function Login(){
		$url = "https://graph.qq.com/oauth2.0/authorize";
		$config_params = \Yii::$app->params;
		$params = [
			'client_id' => $config_params['oauth']['qq']['ak'],
			'response_type' => 'code',
			'redirect_uri' => $this->getCallback(),
			'state' => "imguowei_888"
		];
		return $url."?".http_build_query( $params );
	}

	public function getAccessToken( $params = [] ){
		$config = \Yii::$app->params['oauth']['qq'];
		$post_params = [
			'client_id' => $config['ak'],
			'client_secret' => $config['as'],
			'grant_type' => 'authorization_code',
			'code' => isset( $params['code'] )?$params['code']:'',
			'redirect_uri' => $this->getCallback()
		];
		$url = "https://graph.qq.com/oauth2.0/token";
		$ret = HttpClient::post( $url,$post_params );

		//qq返回的信息真TM变态还是字符串，咋不去死
		if( strpos( $ret , "callback") !== false ){
			$lpos = strpos($ret, "(");
			$rpos = strrpos($ret, ")");
			$ret  = substr($ret, $lpos + 1, $rpos - $lpos -1);
			$ret = json_decode( $ret,true );

			if( !$ret || isset( $ret['error'] ) ){
				return $this->_err( "错误码：".$ret['error']."，错误信息：".$ret['error_description'] );
			}

		}
		parse_str( $ret ,$token );
		if( !$token || isset( $token['error'] ) ){
			return $this->_err( $ret['error'] );
		}
		return $token;
	}


	public function getUserInfo( $access_token,$params = [] ){
		$openid  = $this->getOpenId( $access_token );
		if( !$openid ){
			return false;
		}
		$config = \Yii::$app->params['oauth']['qq'];
		$url = "https://graph.qq.com/user/get_user_info";
		$get_params = [
			'access_token' => $access_token,
			'openid' => $openid,
			'oauth_consumer_key' => $config['ak']
		];
		$ret = HttpClient::get( $url."?".http_build_query( $get_params ) );
		$ret = @json_decode( $ret,true );
		if( !$ret || $ret['ret'] != 0 ){
			return $this->_err( $ret['msg'] );
		}
		$ret['openid'] = $openid;
		$ret['name'] = $ret['nickname'];
		$ret['avatar'] = $ret['figureurl_2'];
		return $ret;
	}

	private function getOpenId( $access_token ){
		$url = "https://graph.qq.com/oauth2.0/me";
		$get_params = [
			'access_token' => $access_token
		];
		$ret = HttpClient::get( $url."?".http_build_query( $get_params ) );
		//qq返回的信息真TM变态还是字符串，咋不去死
		if( strpos( $ret , "callback") !== false ){
			$lpos = strpos($ret, "(");
			$rpos = strrpos($ret, ")");
			$ret  = substr($ret, $lpos + 1, $rpos - $lpos -1);
			$ret = json_decode( $ret,true );

			if( !$ret || isset( $ret['error'] ) ){
				return $this->_err( "错误码：".$ret['error']."，错误信息：".$ret['error_description'] );
			}
		}
		return $ret['openid'];
	}

	private  function getCallback(){
		$callback = \Yii::$app->params['oauth']['qq']['callback'];
		return "http://www.vincentguo.cn".$callback;
	}
}