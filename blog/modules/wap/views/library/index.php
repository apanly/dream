<?php
use blog\components\StaticService;
StaticService::includeAppCssStatic("/css/wap/library/index.css",\blog\assets\WapAsset::className());
StaticService::includeAppJsStatic("/js/wap/library/index.js",\blog\assets\WapAsset::className());
?>
<div class="am-g">
    <?=$book_list;?>
</div>
<div  class="am-g">
    <div class="loading">
        <div class="bubble">
            <div class="bubble1"></div>
            <div class="bubble2"></div>
        </div>
        <p class="loading_txt">图书马上来</p>
    </div>
</div>