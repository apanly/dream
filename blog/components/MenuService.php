<?php
namespace blog\components;

use common\service\GlobalUrlService;
use Yii;

class MenuService
{

	public static function blogMenu()
	{

		$menu = [
			'blog'      => [
				'title' => '文章',
				'url'   => GlobalUrlService::buildBlogUrl("/")
			],
			'richmedia' => [
				'title' => '富媒体',
				'url'   => GlobalUrlService::buildBlogUrl("/richmedia/index")
			],
			'library'   => [
				'title' => '图书馆',
				'url'   => GlobalUrlService::buildBlogUrl("/library/index")
			],
			'project'   => [
				'title'    => '项目',
				'sub_menu' => [
					[
						'title' => '二维码登录',
						'url'   => UrlService::buildUrl("/default/info", ['id' => 21])
					],
					[
						'title' => '微信墙',
						'url'   => UrlService::buildUrl("/default/info", ['id' => 132])
					],
					[
						'title' => '私人github',
						'url'   => UrlService::buildUrl("/default/info", ['id' => 96])
					],
					[
						'title' => 'QQ音乐',
						'url'   => UrlService::buildUrl("/default/info", ['id' => 80])
					],
					[
						'title' => 'metaweblog',
						'url'   => UrlService::buildUrl("/default/info", ['id' => 91])
					]
				]
			],
			'tools'     => [
				'title'    => '小工具',
				'sub_menu' => [
					[
						'title' => '密码生成器',
						'url'   => GlobalUrlService::buildGameUrl("/tools/index")
					],
					[
						'title' => '字符长度统计',
						'url'   => GlobalUrlService::buildGameUrl("/tools/strlen")
					],
					[
						'title' => 'JSON格式化',
						'url'   => GlobalUrlService::buildGameUrl("/tools/json_format")
					],
					[
						'title' => '点歌台',
						'url'   => GlobalUrlService::buildGameUrl("/music/index")
					],
					[
						'title' => 'Code Preview',
						'url'   => GlobalUrlService::buildBlogUrl("/code/run")
					]
				]
			],
			'about'     => [
				'title' => '关于',
				'url'   => GlobalUrlService::buildBlogUrl("/default/about")
			]
		];


		return $menu;
	}
} 
