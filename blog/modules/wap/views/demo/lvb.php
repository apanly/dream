<?php
use blog\components\StaticService;
use \common\service\GlobalUrlService;
StaticService::includeAppJsStatic("//imgcache.qq.com/open/qcloud/video/vcplayer/TcPlayer-2.2.2.js", \blog\assets\WapAsset::className());
StaticService::includeAppJsStatic("/js/wap/demo/lvb.js", \blog\assets\WapAsset::className());
?>
<ol class="am-breadcrumb">
	<li><a href="<?=GlobalUrlService::buildWapUrl("/demo/index");?>">Demo列表</a></li>
	<li class="am-active">直播示例</li>
</ol>
<div class="am-paragraph am-paragraph-default">
    <article class="am-article">
        <div class="am-article-hd">
            <h1 class="am-article-title">直播示例</h1>
        </div>
        <hr data-am-widget="divider"  class="am-divider am-divider-default"/>
        <div id="id_test_video" style="width:100%; height:auto;"></div>
    </article>
</div>