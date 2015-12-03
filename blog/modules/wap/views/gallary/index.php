<?php
use blog\components\StaticService;
use \blog\components\UrlService;
use \common\service\GlobalUrlService;

StaticService::includeAppCssStatic("/css/wap/gallary/demo.css", \blog\assets\WapAsset::className());
StaticService::includeAppCssStatic("/css/wap/gallary/style.css", \blog\assets\WapAsset::className());
StaticService::includeStaticJs("/jquery/jquery.montage.min.js", \blog\assets\WapAsset::className());
StaticService::includeAppJsStatic("/js/wap/gallary/index.js",\blog\assets\WapAsset::className());
?>
<div class="am-g">
    <a href="javascript:void(0);"><img src="<?=GlobalUrlService::buildStaticUrl("/test/1.jpeg");?>"></a>
    <a href="javascript:void(0);"><img src="<?=GlobalUrlService::buildStaticUrl("/test/2.jpeg");?>"></a>
    <a href="javascript:void(0);"><img src="<?=GlobalUrlService::buildStaticUrl("/test/3.jpeg");?>"></a>
    <a href="javascript:void(0);"><img src="<?=GlobalUrlService::buildStaticUrl("/test/4.jpeg");?>"></a>
    <a href="javascript:void(0);"><img src="<?=GlobalUrlService::buildStaticUrl("/test/5.jpeg");?>"></a>
    <a href="javascript:void(0);"><img src="<?=GlobalUrlService::buildStaticUrl("/test/6.jpeg");?>"></a>
    <a href="javascript:void(0);"><img src="<?=GlobalUrlService::buildStaticUrl("/test/7.jpeg");?>"></a>
    <a href="javascript:void(0);"><img src="<?=GlobalUrlService::buildStaticUrl("/test/8.jpeg");?>"></a>
    <a href="javascript:void(0);"><img src="<?=GlobalUrlService::buildStaticUrl("/test/9.jpeg");?>"></a>
    <a href="javascript:void(0);"><img src="<?=GlobalUrlService::buildStaticUrl("/test/10.jpeg");?>"></a>
    <a href="javascript:void(0);"><img src="<?=GlobalUrlService::buildStaticUrl("/test/11.jpeg");?>"></a>
    <a href="javascript:void(0);"><img src="<?=GlobalUrlService::buildStaticUrl("/test/12.jpeg");?>"></a>
</div>
