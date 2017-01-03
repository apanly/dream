<?php
use \common\service\GlobalUrlService;
?>
<header class="jumbotron">
	<h1>
		<img class="logo" src="<?=GlobalUrlService::buildStaticPic("/images/awephp/logo.png",[ 'h' => 120,'w' => 120 ]);?>">
	</h1>
	<p class="lead"><strong>PHP是世界上最好的语言~~,只想用心写教程</strong></p>
	<p>
		<a class="btn btn-lg btn-default btn-getting-started" href="<?=GlobalUrlService::buildPhpUrl("/docs/info",[ 'id' => 1 ]);?>">开始阅读
		</a>
	</p>
</header>
<main class="benefits container">
	<!-- Example row of columns -->
	<div class="row">
		<div class="col-md-6">
			<h2>PHP是什么</h2>
			<p>最流行，开源且免费，跨平台的服务器脚本语言</p>
		</div>
		<div class="col-md-6">
			<h2>PHP可以做什么</h2>
			<p>服务端脚本：可以开发动态网页</p>
			<p>命令行脚本：可以编写一段 PHP 脚本，并且不需要任何服务器或者浏览器来运行它</p>
		</div>
		<div class="col-md-6">
			<h2>简单易学</h2>
			<p>环境安装简单</p>
			<p>内置API和自带的扩展非常方便调用</p>
			<p>初学者1小时学会并运行 Hello World</p>
		</div>
		<div class="col-md-6">
			<h2>成熟稳定的框架和社区</h2>
			<p>Yaf：鸟哥说是最快的PHP框架</p>
			<p>Yii：是一个 高性能 的，适用于开发 WEB 2.0 应用的 PHP 框架</p>
			<p>Laravel：为 WEB 艺术家创造的 PHP 框架</p>
			<p>ThinkPHP：中文最佳实践PHP开源框架</p>
			<p>。。。。。。</p>
		</div>
	</div>
</main>