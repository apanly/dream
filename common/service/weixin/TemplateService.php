<?php

namespace common\service\weixin;

use common\models\weixin\OauthMember;
use common\service\BaseService;



class TemplateService extends  BaseService{

	public static function changeLogNotice( $openid ){
		$config = \Yii::$app->params['weixin'];
		RequestService::setConfig( $config['appid'],$config['token'],$config['sk'] );

		$template_id = "wqRrE06WLEiu7For5cPb4a-NGg1ZgMOVRuXcd1nMSNI";

		$data = [
			"first" => [
				"value" => "号外啦，演示系统发布啦",
				"color" => "#173177"
			],
			"keyword1" =>[
				"value" => "编程浪子",
				"color" => "#173177"
			],
			"keyword2" =>[
				"value" => "编程浪子为你准备了技术项目盛宴",
				"color" => "#173177"
			],
			"remark" => [
				"value" => "点击这里进入演示系统",
				"color" => "#173177"
			]
		];

		return self::send( $openid,$template_id,"http://www.54php.cn/demo",$data);
	}

    /**
     * 获取微信公众平台的微信公众号id,是否还在关注
     */
    protected static function getOpenId( $openid ){
		if( self::getPublicByOpenId( $openid ) ) {
			return $openid;
		}
        return false;
    }

    public  static function send($openid,$template_id,$url,$data){
        $msg = [
            "touser" => $openid,
            "template_id" => $template_id,
            "url" => $url,
            "data" => $data
        ];

        $token = RequestService::getAccessToken();
        return RequestService::send("message/template/send?access_token=".$token,json_encode( $msg ),'POST');
    }

    private static $maxredirs = 0;

    protected static function getPublicByOpenId($openid){
        $token = RequestService::getAccessToken();
        $ret = RequestService::send("user/info?access_token={$token}&openid={$openid}&lang=zh_CN","GET");
        if( !$ret ){
            self::$maxredirs++;
            if(self::$maxredirs <= 3){
                return self::getPublicByOpenId($openid);
            }
        }

		$info = $ret;

        if(!$info || isset($info['errcode']) ){
            return false;
        }

        if($info['subscribe']){
            return true;
        }
        return false;
    }
}

