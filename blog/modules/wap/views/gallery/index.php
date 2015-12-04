<?php
use blog\components\StaticService;
StaticService::includeAppJsStatic("/js/wap/gallery/index.js",\blog\assets\WapAsset::className());
?>
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
