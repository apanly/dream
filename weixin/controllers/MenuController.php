<?php
namespace weixin\controllers;

use common\service\GlobalUrlService;
use common\service\weixin\WechatConfigService;

class MenuController extends BaseController{

	public function actionSet(){
		$default_source = WechatConfigService::$default_source;
		$source = trim( $this->get( "source" ) );
		$config = WechatConfigService::getConfig( );
		$source = isset( $config[ $source ] )?$source:$default_source;

		$menu  = [
			"button" => [
				[
					"name"       => "演示系统",
					"sub_button" => [
						[
							"name" => "商城系统",
							"type" => "view",
							"url"  => GlobalUrlService::buildBookUrl("/default/index",[ 'from' => $source ])
						],
						[
							"name" => "博客系统",
							"type" => "view",
							"url"  => GlobalUrlService::buildWapUrl("/default/index",[ "from" => $source ])
						],
						[
							"name" => "小工具",
							"type" => "view",
							"url"  => GlobalUrlService::buildBlogUrl("/game/tools/index",[ "from" => $source ])
						],
						[
							"name" => "更多系统",
							"type" => "view",
							"url"  => GlobalUrlService::buildDemoUrl("/",[ "from" => $source ])
						],
					]
				],
				[
					"name"       => "个人博客",
					"sub_button" => [
						[
							"name" => "文章列表",
							"type" => "view",
							"url"  => GlobalUrlService::buildWapUrl("/default/index",[ "from" => $source ])
						],
						[
							"type" => "view",
							"name" => "图书馆",
							"url"  => GlobalUrlService::buildWapUrl("/library/index",[ "from" => $source ])
						]
					]
				],
				[
					"name" => "与我联系",
					"sub_button" => [
						[
							"name" => "作者介绍",
							"type" => "view",
							"url"  => GlobalUrlService::buildWapUrl("/my/about",[ "from" => $source ])
						],
						[
							"type" => "view",
							"name" => "赞助浪子",
							"url"  => GlobalUrlService::buildWapUrl("/my/about",[ "from"=> $source,"#" => "contact"])
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


		RequestService::setConfig( $config['appid'],$config['token'],$config['sk'] );
		$access_token = RequestService::getAccessToken();
		if( $access_token ){
			$url = "menu/create?access_token={$access_token}";
			$ret = RequestService::send( $url,json_encode($menu,JSON_UNESCAPED_UNICODE), 'POST' );
			var_dump( $ret );
		}
	}
}
