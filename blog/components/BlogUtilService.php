<?php
namespace blog\components;

use common\service\GlobalUrlService;
use Yii;

class BlogUtilService {

	public static function blogMenu()
	{

		$menu = [
			'blog'      => [
				'title' => '文章',
				'url'   => GlobalUrlService::buildBlogUrl("/")
			],
			'library'   => [
				'title' => '图书馆',
				'url'   => GlobalUrlService::buildBlogUrl("/library/index")
			],
			'donation'   => [
				'title' => '赞助',
				'url'   => GlobalUrlService::buildBlogUrl("/default/donation")
			],
			'project'   => [
				'title'    => '项目',
				'sub_menu' => [
					[
						'title' => 'Yii2打造后台+微信全栈图书商城',
						'url'   => GlobalUrlService::buildBookUrl("/")
					],
					[
						'title' => '二维码登录',
						'url'   => UrlService::buildUrl("/default/info", ['id' => 21])
					],
					[
						'title' => '微信墙',
						'url'   => UrlService::buildUrl("/default/info", ['id' => 132])
					],
					[
						'title' => 'QQ、微博、Github登录',
						'url'   => UrlService::buildUrl("/default/info", ['id' => 191 ])
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
					],[
						'title' => 'H5拍照上传',
						'url'   => UrlService::buildUrl("/default/info", ['id' => 150])
					],[
						'title' => '条形码和二维码',
						'url'   => UrlService::buildUrl("/default/info", ['id' => 152])
					],[
						'title' => '【运维工具】Git代码发布系统',
						'url'   => UrlService::buildUrl("/default/info", ['id' => 151])
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
						'url'   => GlobalUrlService::buildBlogUrl("/code/run"),
						'status' => 0
					]
				]
			],
			'business' => [
				'title' => '商业合作',
				'tip' => '定制开发程序，数据库维护，服务器运维',
				'url'   => GlobalUrlService::buildBlogUrl("/business/index"),
				'status' => 0
			],
			'about'     => [
				'title' => '关于',
				'sub_menu' => [
					[
						'title' => '编程浪子',
						'url'   => GlobalUrlService::buildBlogUrl("/default/about")
					],[
						'title' => '富媒体',
						'url'   => GlobalUrlService::buildBlogUrl("/richmedia/index")
					],[
						'title' => '更新日志',
						'url'   => GlobalUrlService::buildBlogUrl("/default/change-log")
					]
				]

			]
		];


		return $menu;
	}

	public static function getChangeLog(){

		$list = [
			[
				'date' => '2016-12-21',
				'title' => '加入数据库备份功能',
				'content' => '<ol>
<li>每日备份数据库并同步文件到CDN存储</li>
</ol>'
			],
			[
				'date' => '2016-11-19',
				'title' => '运维发布功能',
				'content' => '<ol>
<li>admin后台加入运维发布代码模块</li>
</ol>'
			],
			[
				'date' => '2016-11-07',
				'title' => '全站增加CSP安全策略',
				'content' => '<ol>
<li>全站增加CSP安全策略，不想为劫持广告背锅</li>
</ol>'
			],
			[
				'date' => '2016-10-21',
				'title' => '博客管理后台全新UI改版',
				'content' => '<ol>
<li>博客管理后台全新UI改版</li>
</ol>'
			],
			[
				'date' => '2016-10-15',
				'title' => '博客V1.4.3上线',
				'content' => '<ol>
<li>增加文章阅读量展示</li>
<li>修改热门博文列表</li>
</ol>'
			],
			[
				'date' => '2016-08-08',
				'title' => '博客V1.4.2上线',
				'content' => '<ol>
<li>增加条形码和二维码DEMO</li>
<li>图书馆书籍详情加入ISBN条形码</li>
</ol>'
			],
			[
				'date' => '2016-08-05',
				'title' => '博客V1.4.1上线',
				'content' => '<ol>
<li>博文详情代码高亮插件：prettify</li>
<li>博文图片自适应排除一些非CDN图片</li>
</ol>'
			],
			[
				'date' => '2016-07-17',
				'title' => '博客V1.4上线',
				'content' => '<ol>
<li>博文详情加入扫一扫手机阅读</li>
</ol>'
			],
			[
				'date' => '2016-07-05',
				'title' => '开发混合App',
				'content' => '<ol>
<li>使用HBuilder开发混合App</li>
</ol>'
			],
			[
				'date' => '2016-06-30',
				'title' => '博客V1.3上线',
				'content' => '<ol>
<li>加入更新日志页面</li>
</ol>'
			],
			[
				'date' => '2016-06-24',
				'title' => '博客V1.2.9上线',
				'content' => '<ol>
<li>加入SSL账号加密解密功能</li>
<li>小工具，JSON格式化功能</li>
</ol>'
			],
			[
				'date' => '2016-06-22',
				'title' => '博客V1.2.8上线',
				'content' => '<ol>
<li>小工具，字符串长度统计功能</li>
</ol>'
			],
			[
				'date' => '2016-06-14',
				'title' => '博客V1.2.7上线',
				'content' => '<ol>
<li>网站全部支持HTTPS</li>
</ol>'
			],
			[
				'date' => '2016-05-31',
				'title' => '博客V1.2.6上线',
				'content' => '<ol>
<li>微信墙功能</li>
</ol>'
			],
			[
				'date' => '2016-05-21',
				'title' => '博客V1.2.5上线',
				'content' => '<ol>
<li>记录JS错误信息到数据库</li>
</ol>'
			],
			[
				'date' => '2016-01-12',
				'title' => '博客V1.2.3上线',
				'content' => '<ol>
<li>推荐算法完成</li>
<li>博文推荐功能上线</li>
</ol>'
			],
			[
				'date' => '2016-01-08',
				'title' => '博客V1.2.2上线',
				'content' => '<ol>
<li>异步同步博文到多个博客平台</li>
</ol>'
			],
			[
				'date' => '2015-12-24',
				'title' => '博客V1.2上线',
				'content' => '<ol>
<li>错误信息记录到数据库</li>
<li>访问日志记录到数据库</li>
<li>小工具，QQ点歌台</li>
</ol>'
			],
			[
				'date' => '2015-11-12',
				'title' => '博客V1.1.7上线',
				'content' => '<ol>
<li>小工具功能，在线密码生成器上线</li>
<li>展示图片如果是Retina，2倍展示</li>
</ol>'
			],
			[
				'date' => '2015-11-11',
				'title' => '博客V1.1.5上线',
				'content' => '<ol>
<li>静态资源全部移入七牛云CDN</li>
<li>使用微信手机端网页静默授权登录</li>
</ol>'
			],
			[
				'date' => '2015-11-05',
				'title' => '博客V1.1.2上线',
				'content' => '<ol>
<li>每天备份数据库Job，并压缩备份文件</li>
</ol>'
			],
			[
				'date' => '2015-10-30',
				'title' => '博客V1.1.1上线',
				'content' => '<ol>
<li>增加sitemap</li>
<li>UrlService全部使用全路径</li>
<li>视频高度自适应</li>
<li>加入原创标签</li>
<li>PC端增加多说模块</li>
</ol>'
			],
			[
				'date' => '2015-10-23',
				'title' => '博客V1.1上线',
				'content' => '<ol>
<li>手机App同步健康数据</li>
<li>手机H5端网页 m.vincentguo.cn</li>
<li>手机访问www跳转到m下</li>
</ol>'
			],
			[
				'date' => '2015-10-19',
				'title' => '博客V1.0.6上线',
				'content' => '<ol>
<li>SEO工作,美化URL，文章加入html后缀</li>
<li>加入404错误页面</li>
</ol>'
			],
			[
				'date' => '2015-10-17',
				'title' => '博客V1.0.5上线',
				'content' => '<ol>
<li>增加文件管理功能</li>
<li>增加统一上传服务（所有图片统一管理）</li>
</ol>'
			],
			[
				'date' => '2015-10-13',
				'title' => '博客V1.0.5上线',
				'content' => '<ol>
<li>微信服务号(imguowei_888)上线</li>
<li>文章列表增加封面图片(如果博文有图片)</li>
</ol>'
			],
			[
				'date' => '2015-10-11',
				'title' => '博客V1.0.3上线',
				'content' => '<ol>
<li>富媒体图片增加GPS和TIFF解析</li>
<li>图书馆列表</li>
</ol>'
			],
			[
				'date' => '2015-10-05',
				'title' => '博客V1.0.2上线',
				'content' => '<ol>
<li>Iphone App实现简单上传图片功能</li>
<li>扫描图书ISBN条形码提交到图书馆</li>
</ol>'
			],
			[
				'date' => '2015-10-03',
				'title' => '博客V1.0.1上线',
				'content' => '<ol>
<li>加入富媒体列表</li>
<li>实现简单图片服务</li>
<li>图片服务实现缓存功能</li>
</ol>'
			],
			[
				'date' => '2015-09-30',
				'title' => '博客V1.0上线',
				'content' => '<ol>
<li>文章列表</li>
<li>搜索功能</li>
<li>文章Tag</li>
<li>Spider采集指定网站文章</li>
<li>静态资源加入版本号</li>
</ol>'
			],
			[
				'date' => '2015-09-15',
				'title' => '写下了第一行代码',
				'content' => '选用Yii2框架，开始了博客生涯'
			]
		];
		return $list;
	}


} 
