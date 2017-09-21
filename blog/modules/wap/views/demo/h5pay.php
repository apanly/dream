<?php
use blog\components\StaticService;
use \common\service\GlobalUrlService;
StaticService::includeAppJsStatic("/js/wap/demo/h5pay.js", \blog\assets\WapAsset::className());
?>

<div class="am-paragraph am-paragraph-default">
    <article class="am-article">
        <div class="am-article-hd">
            <h1 class="am-article-title">H5支付</h1>
        </div>
        <hr data-am-widget="divider"  class="am-divider am-divider-default"/>
        <div class="am-article-bd  am-form">
            <div class="am-form-group">
                <input type="text" name="email"  placeholder="请输入支付url">
            </div>
            <p><button type="button" class="pay am-btn am-btn-primary am-btn-block">支付Demo</button></p>
        </div>

    </article>
</div>

