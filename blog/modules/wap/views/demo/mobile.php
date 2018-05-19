<?php
use blog\components\StaticService;
use \common\service\GlobalUrlService;
StaticService::includeAppJsStatic("/js/wap/demo/h5_upload.js", \blog\assets\WapAsset::className());
?>
<ol class="am-breadcrumb">
	<li><a href="<?=GlobalUrlService::buildWapUrl("/demo/index");?>">Demo列表</a></li>
	<li class="am-active">手机归属地查询</li>
</ol>
<div class="am-paragraph am-paragraph-default">
	<article class="am-article">
		<div class="am-article-hd">
			<h1 class="am-article-title">手机归属地查询</h1>
		</div>
	</article>
</div>

