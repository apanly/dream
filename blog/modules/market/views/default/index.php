<?php
use blog\components\StaticService;
use \common\service\GlobalUrlService;

StaticService::includeAppCssStatic("/css/market/index.css", \blog\assets\SuperMarketAsset::className());
StaticService::includeStaticJs("/jquery/TouchSlide/TouchSlide.1.1.js", \blog\assets\SuperMarketAsset::className());
StaticService::includeAppJsStatic("/js/market/default/index.js", \blog\assets\SuperMarketAsset::className());

?>
<style type="text/css">
    /* 本例子css -------------------------------------- */
    .focus {
        width: 100%;
        height: 350px;
        margin: 0 auto;
        position: relative;
        overflow: hidden;
    }

    .focus .hd {
        width: 100%;
        height: 5px;
        position: absolute;
        z-index: 1;
        bottom: 0;
        text-align: center;
    }

    .focus .hd ul {
        overflow: hidden;
        display: -moz-box;
        display: -webkit-box;
        display: box;
        height: 5px;
        background-color: rgba(51, 51, 51, 0.5);
    }

    .focus .hd ul li {
        -moz-box-flex: 1;
        -webkit-box-flex: 1;
        box-flex: 1;
    }

    .focus .hd ul .on {
        background: #FF4000;
    }

    .focus .bd {
        position: relative;
        z-index: 0;
    }

    .focus .bd li img {
        width: 100%;
        height: 350px;
    }

    .focus .bd li a {
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0); /* 取消链接高亮 */
    }
</style>
<div class="container-fluid">
    <div class="row hide" style="margin: 0;padding: 0;">
        <div class="col-md-12 col-sm-12">
            <div id="focus" class="focus">
                <div class="hd"><ul></ul></div>
                <div class="bd">
                    <ul>
                        <li><a href="<?=GlobalUrlService::buildNullUrl();?>"><img src="<?= GlobalUrlService::buildStaticUrl("/images/market/1.jpg"); ?>"></a></li>
                        <li><a href="<?=GlobalUrlService::buildNullUrl();?>"><img src="<?= GlobalUrlService::buildStaticUrl("/images/market/2.jpg"); ?>"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="page-header">
        <h3>小程序示例</h3>
    </div>
    <div class="row" style="padding: 0 30px;">
		<?php foreach( $mina_list as $_item  ):?>
            <div class="col-sm-6 col-md-3 col-lg-3">
                <div class="thumbnail">
                    <a href="<?=GlobalUrlService::buildSuperMarketUrl("/default/info",[ "id" => $_item['id'] ]);?>">
                        <img src="<?=$_item['image_url'];?>" style="height: 400px;">
                        <div class="caption" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                            <h3><?=$_item['title'];?></h3>
                        </div>
                    </a>

                </div>
            </div>
		<?php endforeach;?>
    </div>

    <div class="page-header">
        <h3>建站示例</h3>
    </div>
    <div class="row" style="padding: 0 30px;">
		<?php foreach( $site_list as $_item  ):?>
            <div class="col-sm-6 col-md-3 col-lg-3">
                <div class="thumbnail">
                    <a href="<?=GlobalUrlService::buildSuperMarketUrl("/default/info",[ "id" => $_item['id'] ]);?>">
                        <img src="<?=$_item['image_url'];?>" style="height: 400px;">
                        <div class="caption" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                            <h3><?=$_item['title'];?></h3>
                        </div>
                    </a>

                </div>
            </div>
		<?php endforeach;?>
    </div>


</div>


