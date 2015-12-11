<?php
use blog\components\StaticService;
use \blog\components\UrlService;

StaticService::includeAppCssStatic("/css/wap/default/index.css", \blog\assets\WapAsset::className());
StaticService::includeAppJsStatic("/js/wap/default/index.js", \blog\assets\WapAsset::className());
?>
<div class="am-g" id="se_btn">
    <a href="<?= UrlService::buildWapUrl("/default/index", ["type" => 1]); ?>"
       class="am-btn am-btn-default am-u-sm-3 am-u-md-3">文章</a>
    <a href="<?= UrlService::buildWapUrl("/default/index", ["type" => 2]); ?>"
       class="am-btn am-btn-default am-u-sm-3 am-u-md-3">热门</a>
    <a href="<?= UrlService::buildWapUrl("/default/index", ["type" => 3]); ?>"
       class="am-btn am-btn-default am-u-sm-3 am-u-md-3">原创</a>
    <a href="<?= UrlService::buildWapUrl("/search/do"); ?>"
       class="am-btn am-btn-default am-u-sm-3 am-u-md-3"><span class="am-icon-search"></span></a>
</div>
<div data-am-widget="list_news" class="am-list-news am-list-news-default">
    <div class="am-list-news-bd">
        <ul class="am-list">
            <?= $post_list_html; ?>
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

<input type="hidden" id="type" value="<?= $type; ?>"/>
