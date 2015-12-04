<?php
use blog\components\StaticService;
use \blog\components\UrlService;
use \common\service\GlobalUrlService;

StaticService::includeAppCssStatic("/css/wap/gallary/demo.css", \blog\assets\WapAsset::className());
StaticService::includeAppCssStatic("/css/wap/gallary/style.css", \blog\assets\WapAsset::className());
StaticService::includeStaticJs("/jquery/jquery.montage.min.js", \blog\assets\WapAsset::className());
StaticService::includeAppJsStatic("/js/wap/gallery/list.js",\blog\assets\WapAsset::className());
?>
<?php if( $images ):?>
<div class="am-g">
    <?php foreach( $images as $_url ):?>
    <a href="javascript:void(0);">
        <img src="<?=$_url;?>">
    </a>
    <?php endforeach;?>
</div>
<?php endif;?>