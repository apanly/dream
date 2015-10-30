<?php
use blog\components\StaticService;

StaticService::includeAppCssStatic("/css/wap/richmedia/index.css", \blog\assets\WapAsset::className());
StaticService::includeAppJsStatic("/js/wap/richmedia/index.js", \blog\assets\WapAsset::className());
?>
<ul data-am-widget="gallery" class="am-gallery am-avg-sm-1 am-gallery-overlay" data-am-gallery="{ pureview: true }">
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
