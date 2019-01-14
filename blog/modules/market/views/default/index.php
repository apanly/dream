<?php

use blog\components\StaticService;
use \common\service\GlobalUrlService;
use \common\components\DataHelper;

StaticService::includeAppCssStatic("/css/market/articles.css", \blog\assets\SuperMarketAsset::className());
?>
<style type="text/css">
    .carousel-caption {
        left: 25%;
        top: 0px;
        right: 5%;
        bottom: auto;
        padding-top: 0;
    }

    .carousel-caption h3 {
        line-height: 50px;
        margin-top: 0;
    }
</style>
<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div id="banner_wrap" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#banner_wrap" data-slide-to="0" class="active"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <a class="item active" href="<?= $ngrok_url; ?>">
                    <img src="http://cdn.pic1.54php.cn/20190112/1a3242f0896446cafa283d2ab6d50a00.png" alt="...">
                    <div class="carousel-caption" style="text-align: left;">
                        <h3>
                            提供内网穿透服务，支持http和https<br/>
                            管理内网服务器，内网web进行演示<br/>
                            快速开发微信、小程序和第三方支付平台调试<br/>
                            本地WEB外网访问、本地开发微信<br/>
                            无需任何配置，下载客户端之后直接一条命令让外网访问您的内网不再是距离
                        </h3>
                        <p>
                            <button type="button" class="btn btn-danger btn-lg">了解更多</button>
                        </p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <section class="panel panel-default articles-index-main">
            <ul class="list-unstyled articles-index-list">
				<?php foreach ($data as $_item): ?>
                    <li class="index-article-item ">
                        <a class="article-item-image"
                           href="<?= GlobalUrlService::buildSuperMarketUrl("/default/info", ["id" => $_item['id']]); ?>">
                            <img src="<?= $_item['image_url']; ?>">
                        </a>
                        <div class="article-item-text">
                            <a class="article-item-title"
                               href="<?= GlobalUrlService::buildSuperMarketUrl("/default/info", ["id" => $_item['id']]); ?>">
                                <h1><?= $_item['title']; ?></h1></a>
                            <p class="article-item-tags">
                                <a href="<?= GlobalUrlService::buildNullUrl(); ?>"
                                   class="article-tag-element"><?= $_item['type_desc']; ?></a>
                            </p>
                            <p class="article-item-desc">
								<?= $_item['content']; ?>
                            </p>
                            <p class="article-item-options">
                                <span class="article-item-time">发布于：<span><?= $_item['date']; ?></span></span>
                                <a href="<?= GlobalUrlService::buildSuperMarketUrl("/default/info", ["id" => $_item['id']]); ?>"
                                   class="pull-right article-item-more">阅读全文&gt;&gt;</a>
                            </p>
                        </div>
                    </li>
				<?php endforeach; ?>
            </ul>
        </section>
    </div>
</div>