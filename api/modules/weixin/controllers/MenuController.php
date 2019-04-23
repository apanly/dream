<?php
namespace api\modules\weixin\controllers;


use api\modules\weixin\controllers\common\BaseController;
use api\modules\weixin\controllers\WxrequestController;


use blog\components\UrlService;
use common\service\GlobalUrlService;
use Yii;

class MenuController extends BaseController{

    public  function actionCreate( )
    {
        if (!$this->checkSignature()) {
            return false;
        }

        $from  = $this->getSource();

        $menu  = [
            "button" => [
				[
					"name"       => "演示系统",
					"sub_button" => [
						[
							"name" => "商城系统",
							"type" => "view",
							"url"  => GlobalUrlService::buildBookUrl("/")
						],
						[
							"name" => "博客系统",
							"type" => "view",
							"url"  => GlobalUrlService::buildWapUrl("/default/index",[ "from" => "imguowei_888" ])
						],
						[
							"name" => "小工具",
							"type" => "view",
							"url"  => GlobalUrlService::buildGameUrl("/tools/index",[ "from" => "imguowei_888" ])
						],
						[
							"name" => "更多系统",
							"type" => "view",
							"url"  => GlobalUrlService::buildDemoUrl("/",[ "from" => "imguowei_888" ])
						],
					]
				],
				[
					"name"       => "个人博客",
					"sub_button" => [
						[
							"name" => "文章列表",
							"type" => "view",
							"url"  => GlobalUrlService::buildWapUrl("/default/index",[ "from" => "imguowei_888" ])
						],
						[
							"type" => "view",
							"name" => "图书馆",
							"url"  => GlobalUrlService::buildWapUrl("/library/index",[ "from" => "imguowei_888" ])
						],
						[
							"type" => "view",
							"name" => "机器学习",
							"url"  => "https://git.home.54php.cn:4443/fork/100-Days-Of-ML-Code"
						]
					]
				],
				[
					"name" => "与我联系",
					"sub_button" => [
						[
							"name" => "作者介绍",
							"type" => "view",
							"url"  => GlobalUrlService::buildWapUrl("/my/about",[ "from" => "imguowei_888" ])
						],
						[
							"type" => "view",
							"name" => "赞助浪子",
							"url"  => GlobalUrlService::buildWapUrl("/my/about",[ "from"=> "imguowei_888","#" => "contact"])
						],
						[
							"type" => "view",
							"name" => "浪子鸡汤",
							"url"  => "https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzU0MDAwNDY2OQ==&scene=124#wechat_redirect"
						]
					]
				]
            ]
        ];

        $access_token = WxrequestController::getAccessToken();
        if( !$access_token ){
            $access_token = WxrequestController::getAccessToken( true );
        }

        return WxrequestController::send("menu/create?access_token=" . $access_token, json_encode($menu,JSON_UNESCAPED_UNICODE), 'POST');
    }

    public static function delete()
    {

    }

}
