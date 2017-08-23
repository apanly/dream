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

			'market'   => [
				'title' => '源码下载',
				'url'   => GlobalUrlService::buildSuperMarketUrl("/"),
				'status' => 1
			],
			'donation'   => [
				'title' => '赞助',
				'url'   => GlobalUrlService::buildBlogUrl("/default/donation")
			],
			'project'   => [
				'title'    => '演示系统',
				'url'   => GlobalUrlService::buildDemoUrl("/")
			],
			'library'   => [
				'title' => '图书馆',
				'url'   => GlobalUrlService::buildBlogUrl("/library/index")
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
				'date' => '2017-06-24',
				'title' => '整体架构加入 微信 独立App',
				'content' => '<ol>
<li>将 编程浪子走四方 公众号 接入微信独立App</li>
</ol>'
			],
			[
				'date' => '2017-06-10',
				'title' => '加入个人演示系统',
				'content' => '<ol>
<li>演示系统主要展示个人的一些项目</li>
</ol>'
			],
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

	public static function getProjectList(){
		$menu = [
			[
				'title' => 'Yii2打造后台+微信全栈图书商城',
				'url'   => GlobalUrlService::buildBookUrl("/"),
				"cover" => "http://cdn.pic1.54php.cn/20170610/befdb7b8578dcb675c24288d6a505348.jpg?imageView/2/w/300",
				'desc'  => '基于微信服务号的图书商城,包含支付系统、消息模板、二维码的渠道、自定义菜单、微信授权登录、商业统计、手机验证码',
				"pay" => true
			],
			[
				'title' => 'RBAC打造通用web管理权限',
				'url'   => GlobalUrlService::buildBlogUrl("/default/info", [ 'id' => 42 ]),
				'cover' => "http://cdn.pic1.54php.cn/20170610/13a5e6693e3de0a6319a7edc57c826ed.jpg?imageView/2/w/300",
				'desc'  => 'RBAC是商业系统中最常见的权限管理技术之一。RBAC是一种思想，任何编程语言都可以实现，其成熟简单的控制思想 越来越受广大开发人员喜欢'
			],
			[
				'title' => 'vagrant打造跨平台可移动的开发环境',
				'url'   => GlobalUrlService::buildBlogUrl("/default/info", [ 'id' => 26 ]),
				'cover' => "http://cdn.pic1.54php.cn/20170610/a4f4ddccfd3201ee87e139be118da8dd.jpg?imageView/2/w/300",
				"desc" => "Vagrant目前是国内互联网公司应用最多的内部开发环境工具。Vagrant是我们开发者的福音，使我们完全摆脱了重复配置环境的处境"
			],
			[
				'title' => '房价变动及时知道',
				'url'   => GlobalUrlService::buildScrapyUrl("/"),
				'cover' => "http://cdn.pic1.54php.cn/20170610/4c0b12fa607d70ec5427fc4bae97cb13.jpg?imageView/2/w/300",
				"desc" => "新房爬虫，及时知道房价变动，虽然房价很贵，但是实话告诉你，房价还在涨"
			],
			[
				'title' => '编程浪子梦博客',
				'url'   => GlobalUrlService::buildBlogUrl("/"),
				'cover' => "http://cdn.pic1.54php.cn/20170611/0fe21515c51c8d61d62a5308ec49b43c.jpg?imageView/2/w/300",
				"desc" => "梦想谁都有，我就是想通过这个博客和更多的人结交朋友"
			],
			[
				'title' => '二维码登录',
				'url'   => GlobalUrlService::buildBlogUrl("/default/info", ['id' => 21]),
				"cover" => "http://cdn.pic1.54php.cn/20151002/20151002001803_897420a8.jpg?imageView/2/w/300",
				"desc" => "常见的扫描登录的实现原理讲解，让你也可以实现高大上的扫描登录"
			],
			[
				'title' => '微信墙',
				'url'   => GlobalUrlService::buildBlogUrl("/default/info", ['id' => 132]),
				"cover" => "http://cdn.pic1.54php.cn/20160616/4b381f1b8b9b669092184f001a11fd97.jpg?imageView/2/w/300",
				"desc" => "传统墙与微信的结合，为活动助兴"
			],
			[
				'title' => 'QQ、微博、Github登录',
				'url'   => GlobalUrlService::buildBlogUrl("/default/info", ['id' => 191 ]),
				"cover" => "http://cdn.pic1.54php.cn/20170103/daa7636b15f14de41c14c5dcb7581e6a.jpg?imageView/2/w/300",
				"desc" => "通用Oauth系统设计，以QQ，微博为例，方便任何第三方系统接入"
			],
			[
				'title' => '边玩游戏边学Git',
				'url'   => "http://wiki.54php.cn/git/",
				"cover" => "http://cdn.pic1.54php.cn/20170620/0ce648828260f2b3a0a9908000d13ff7.jpg?imageView/2/w/300",
				"desc" => "你对 Git 感兴趣吗？那么算是来对地方了！ “Learning Git Branching” 可以说是目前为止最好的教程了，在沙盒里你能执行相应的命令，还能看到每个命令的执行情况"
			],
			[
				'title' => '私人github',
				'url'   => GlobalUrlService::buildBlogUrl("/default/info", ['id' => 96]),
				"cover" => "http://cdn.pic1.54php.cn/20160116/044f386c88e7a395e7b9430c8b344874.jpg?imageView/2/w/300",
				"desc" => "如果你严肃对待编程，就必定会使用\"版本管理系统\"（Version Control System）。眼下最流行的\"版本管理系统\"，非Git莫属"
			],
			[
				'title' => 'QQ音乐',
				'url'   => GlobalUrlService::buildBlogUrl("/default/info", ['id' => 80]),
				'cover' => 'http://cdn.pic1.54php.cn/20151226/b1c2429a76041a67a476f02000b58e07.jpg?imageView/2/w/300',
				"desc" => "不会爬虫，怎么敢说自己是程序员了，要爬就爬BAT，以腾讯QQ微源，打造自己的QQ音乐平台"
			],
			[
				'title' => 'metaweblog',
				'url'   => GlobalUrlService::buildBlogUrl("/default/info", ['id' => 91]),
				"cover" => "http://cdn.pic1.54php.cn/20160110/d0783b7ecfc5c6dcc55efc4cc4ab123c.jpg?imageView/2/w/300",
				"desc" => "还在人肉同步博客嘛，outman 了，试试这个，绝对让你耳目一新"
			],[
				'title' => 'H5拍照上传',
				'url'   => GlobalUrlService::buildBlogUrl("/default/info", ['id' => 150]),
				"cover" => "http://cdn.pic1.54php.cn/20160802/70b60ba962ccb59927e1f2790022c878.jpg?imageView/2/w/300",
				"desc" => "H5越来越流行了，在不试试你就Out了，一起来玩玩拍照"
			],[
				'title' => '条形码和二维码',
				'url'   => GlobalUrlService::buildBlogUrl("/default/info", ['id' => 152]),
				"cover" => "http://cdn.pic1.54php.cn/20160808/6276e49a59f8e3cbb0b6f8401cee59d3.jpg?imageView/2/w/300",
				"desc" => "PHP如何生成二维码，Let's Go"
			],[
				'title' => '【运维工具】Git代码发布系统',
				'url'   => GlobalUrlService::buildBlogUrl("/default/info", ['id' => 151]),
				"cover" => "http://cdn.pic1.54php.cn/20161121/48514e6db097ea7bc9cb88aece2ad032.png?imageView/2/w/300",
				"desc" => "自动化是运维团队追求的终极目标，发布系统必将是自动化的第一炮"
			],
			[
				'title' => '高逼格图书馆',
				'url'   => GlobalUrlService::buildBlogUrl("/default/info", ['id' => 50 ]),
				"cover" => "http://cdn.pic1.54php.cn/20151017/e58d1fec47f42f6e4b46ed2dfc1c6ba4.jpg?imageView/2/w/300",
				"desc" => "图书馆都见过，程序猿打招自己的高逼格电子图书馆"
			],
			[
				'title' => '小工具集合',
				'url'   => GlobalUrlService::buildGameUrl("/tools/index"),
				"cover" => "http://cdn.pic1.54php.cn/20170611/a121207a7554198b81f89e4d0ac1a184.jpg?imageView/2/w/300",
				"desc" => "个人写了几个常用小工具，密码生成器、JSON格式化、字符长度"
			],
		];

		return $menu;
	}

} 
