<?php
use blog\components\StaticService;
use \blog\components\UrlService;
StaticService::includeAppJsStatic("/js/wap/gallery/index.js",\blog\assets\WapAsset::className());
?>
<div class="am-g" id="se_btn">
    <a href="<?=UrlService::buildWapUrl("/richmedia/index");?>" class="am-btn am-btn-default am-u-sm-6 am-u-md-6 am-u-lg-6">
        看今朝
    </a>
    <a href="javascript:void(0);" class="am-btn am-btn-default am-u-sm-6 am-u-md-6 am-u-lg-6      am-btn-success">
        想当年
    </a>
</div>
<ul data-am-widget="gallery" class="am-gallery am-avg-sm-1 am-gallery-overlay am-no-layout"  >
    <?php foreach($gallery_list as $_item):?>
    <li>
        <div class="am-gallery-item">
            <a href="<?=$_item["info_url"];?>">
                <img  data="<?=$_item["switch"];?>" data-src="<?=$_item["cover_src_url"];?>"  alt="<?=$_item["name"];?>"/>
                <h3 class="am-gallery-title"><?=$_item["name"];?></h3>
            </a>
        </div>
    </li>
    <?php endforeach;?>
</ul>
