<?php
/**
 * Class WechatConfigService
 */

namespace common\service\weixin;


use common\service\BaseService;

class WechatConfigService extends BaseService {

	public static $default_source = "CodeRonin";

	public static function getConfig( $source = "" ){
		$config = \Yii::$app->params['weixin'];
		$source = isset( $config[ $source ] )?$source:self::$default_source;
		return $config[ $source ];
	}
}