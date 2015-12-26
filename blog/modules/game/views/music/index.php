<?php
use blog\components\StaticService;
use \common\service\GlobalUrlService;
StaticService::includeAppJsStatic("/js/game/music/index.js",blog\assets\GameAsset::className());
?>
<div class="am-u-sm-12 am-u-md-12 am-u-lg-12 am-text-center">
    <img src="<?=GlobalUrlService::buildStaticUrl("/images/game/music/logo.png");?>" style="height: 150px;width: 150px;">
</div>
<div class="am-u-sm-12 am-u-md-12  am-u-lg-12">
    <form method="get" id="search">
        <div class="am-input-group am-input-group-default">
            <input type="text"  name="kw" class="am-form-field" placeholder="输入歌名或歌手~" value="<?=$kw;?>">
            <span class="am-input-group-btn">
                <button class="am-btn am-btn-default btn-search" type="button">
                    <span class="am-icon-search"></span>
                </button>
            </span>
        </div>
    </form>
</div>
<div class="am-u-sm-12 am-u-md-12  am-u-lg-12">
    <?php if($music_list):?>
        <ul class="am-list am-list-striped am-list-border">
            <?php foreach( $music_list as $_music_info ):?>
                <li>
                    <a href="<?=$_music_info['view_url'];?>" class="am-list-item-hd ">
                        <?=$_music_info['song_title'];?> -- <?=$_music_info['song_author'];?>
                    </a>
                </li>
            <?php endforeach;?>
        </ul>
    <?php else:?>
    <?php endif;?>
</div>