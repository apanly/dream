<?php
use blog\components\StaticService;
use \blog\components\UrlService;
StaticService::includeAppCssStatic("/css/wap/richmedia/index.css", \blog\assets\WapAsset::className());
StaticService::includeAppJsStatic("/js/wap/richmedia/index.js", \blog\assets\WapAsset::className());
?>
<div class="am-g" id="se_btn">
    <a href="javascript:void(0);" class="am-btn am-btn-default am-u-sm-6 am-u-md-6 am-u-lg-6 am-btn-success">
        看今朝
    </a>
    <a href="<?=UrlService::buildWapUrl("/gallery/index");?>" class="am-btn am-btn-default am-u-sm-6 am-u-md-6 am-u-lg-6">
        想当年
    </a>
</div>
<ul data-am-widget="gallery" class="am-gallery am-avg-sm-1 am-gallery-overlay">
    <?= $media_list_html; ?>
</ul>
<div class="am-g">
    <div class="loading">
        <div class="bubble">
            <div class="bubble1"></div>
            <div class="bubble2"></div>
        </div>
        <p class="loading_txt">富媒体马上来</p>
    </div>
</div>
