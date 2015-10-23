<?php
use blog\components\StaticService;
StaticService::includeAppCssStatic("/css/wap/default/index.css",\blog\assets\WapAsset::className());
StaticService::includeAppJsStatic("/js/wap/default/index.js",\blog\assets\WapAsset::className());
?>
<div data-am-widget="list_news" class="am-list-news am-list-news-default" >
    <div class="am-list-news-bd">
        <ul class="am-list">
            <?=$post_list_html;?>
        </ul>
    </div>
    <div class="loading">
        <div class="bubble">
            <div class="bubble1"></div>
            <div class="bubble2"></div>
        </div>
        <p class="loading_txt">文章马上来</p>
    </div>
</div>
