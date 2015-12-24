<?php
use blog\components\StaticService;
use \common\service\GlobalUrlService;
StaticService::includeAppCssStatic("/css/game/music/info.css",blog\assets\GameAsset::className());
StaticService::includeAppJsStatic("/js/game/music/info.js",blog\assets\GameAsset::className());
?>
<div class="am-u-sm-12 am-u-md-12 am-u-lg-12 am-text-center">
    <div id="music-pic" style="background-image: url(<?=$info["cover_image"];?>);">
        <img src="<?=GlobalUrlService::buildStaticUrl("/images/game/music/play.png");?>" class="btn_play">
        <img src="<?=GlobalUrlService::buildStaticUrl("/images/game/music/pause.png");?>" class="btn_pause">
        <img src="<?=GlobalUrlService::buildStaticUrl("/images/game/music/refresh.png");?>" class="btn_refresh">
    </div>
    <p>
        <?=$info["song_title"];?><br/>
        <?=$info["song_author"];?>
    </p>
</div>
<div class="am-u-sm-12 am-u-md-12 am-u-lg-12 am-text-center" style="height: 200px;
    overflow: hidden;">
    <div id="lrc_box">

    </div>
</div>
<input type="hidden" id="mid" value="<?=$info["id"];?>">
