<?php


namespace console\controllers;


class DefaultController extends  BaseController {
	public function actionIndex(){
		$_post_url = 'https://api.netease.im/sms/sendcode.action';

		$post_data = [
			"mobile" => "13774355074",
			"code" => "1234"
		];

		$AppKey = "8dee7e59aed3b6460205edc7d675b2db";
		$APPSec = "168df8e34404";
		$Nonce = "sdfsadfsdfsdfsdf";
		$CurTime = time();

		$CheckSum = strtolower(sha1( $APPSec.$Nonce.$CurTime ) );

		$curl = curl_init ( $_post_url );
		curl_setopt ( $curl, CURLOPT_HEADER, 0 );
		$header = array ();
		$header [] = 'User-Agent: ozilla/5.0 (X11; Linux i686) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.835.186 Safari/535.1';
		$header [] = 'Content-Type:application/x-www-form-urlencoded;charset=utf-8';
		$header[] = "AppKey: {$AppKey}";
		$header[] = "Nonce: {$Nonce}";
		$header[] = "CurTime: {$CurTime}";
		$header[] = "CheckSum: {$CheckSum}";
		curl_setopt ( $curl, CURLOPT_HTTPHEADER, $header );
		curl_setopt ( $curl, CURLOPT_VERBOSE, true );
		curl_setopt ( $curl, CURLOPT_POST, 1);
		curl_setopt ( $curl, CURLOPT_POSTFIELDS, http_build_query( $post_data ) );
		$result = curl_exec ( $curl );
		curl_close ( $curl );
		var_dump ( $result );
	}

	function stringToHex ($s) {

		$r = "";

		$hexes = array ("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");

		for ($i=0; $i<strlen($s); $i++) {$r .= ($hexes [(ord($s{$i}) >> 4)] . $hexes [(ord($s{$i}) & 0xf)]);}

		return $r;

	}
}
