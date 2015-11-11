<?php
use \blog\components\UrlService;
?>
<div class="am-g">
    <div class="am-u-lg-12 am-u-md-12 am-u-sm-12">
        <div class="am-btn-toolbar"  style="padding: 0 16px;">
            <?php if( $urls['has_pre'] ):?>
                <a href="<?=UrlService::buildGameUrl("/mv/index",['p' => ($p-1)]);?>" class="am-btn am-btn-warning am-fl">上一组</a>
            <?php else:?>
                <a href="javascript:void(0);" class="am-btn am-btn-default am-fl">上一组</a>
            <?php endif;?>

            <?php if( $urls['has_next'] ):?>
                <a href="<?=UrlService::buildGameUrl("/mv/index",['p' => ($p+1)]);?>" class="am-btn am-btn-warning am-fr">下一组</a>
            <?php else:?>
                <a href="javascript:void(0);" class="am-btn am-btn-default am-fr">下一组</a>
            <?php endif;?>

        </div>
    </div>
    <div class="am-u-lg-12 am-u-md-12 am-u-sm-12">
        <?php if($list):?>
        <ul data-am-widget="gallery" class="am-u-lg-12 am-u-md-12 am-u-sm-12 am-gallery-bordered" >
            <?php foreach($list as $_item):?>
            <li>
                <div class="am-gallery-item">
                    <a href="javascript:void(0);">
                        <img src="<?=$_item['src_url'];?>"  alt="<?=$_item['title'];?>"/>
                        <h3 class="am-gallery-title"><?=$_item['title'];?></h3>
                    </a>
                </div>
            </li>
            <?php endforeach;?>
        </ul>
        <?php endif;?>
    </div>
    <div class="am-u-lg-12 am-u-md-12 am-u-sm-12">
        <div class="am-btn-toolbar"  style="padding: 0 16px;">
            <?php if( $urls['has_pre'] ):?>
                <a href="<?=UrlService::buildGameUrl("/mv/index",['p' => ($p-1)]);?>" class="am-btn am-btn-warning am-fl">上一组</a>
            <?php else:?>
                <a href="javascript:void(0);" class="am-btn am-btn-default am-fl">上一组</a>
            <?php endif;?>

            <?php if( $urls['has_next'] ):?>
                <a href="<?=UrlService::buildGameUrl("/mv/index",['p' => ($p+1)]);?>" class="am-btn am-btn-warning am-fr">下一组</a>
            <?php else:?>
                <a href="javascript:void(0);" class="am-btn am-btn-default am-fr">下一组</a>
            <?php endif;?>
        </div>
    </div>
</div>
