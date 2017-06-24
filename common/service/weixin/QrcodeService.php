<?php
namespace app\common\services\weixin;


use app\common\services\BaseService;
use app\common\services\weixin\RequestService;

class QrcodeService extends  BaseService {
	/**
	 * 临时二维码
	 */
	public static function geneTmp( $id ){
		return self::qr( $id,true );
	}

	/**
	 * 永久二维码最多100000
	 */
	public static function gene( $id ){
		return self::qr( $id );
	}

	private static function qr( $id,$is_tmp = false ){
		$config = \Yii::$app->params['weixin'];
		RequestService::setConfig( $config['appid'],$config['token'],$config['sk'] );
		$token = RequestService::getAccessToken();
		$post_data = [
			'expire_seconds' => 2592000,//2592000（即30天）
			'action_name' => $is_tmp?'QR_SCENE':'QR_LIMIT_SCENE',
			'action_info' => [
				'scene' => [
					'scene_id' => $id
				]
			],
		];
		return RequestService::send( "qrcode/create?access_token={$token}",json_encode( $post_data ),'POST' );
	}
}