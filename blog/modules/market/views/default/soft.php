<?php
use blog\components\StaticService;
use \common\service\GlobalUrlService;
use \common\components\DataHelper;

StaticService::includeAppCssStatic("/css/market/articles.css", \blog\assets\SuperMarketAsset::className());

?>
<div class="container">
	<div class="row" style="margin-top: 5px;">
		<ol class="breadcrumb">
			<li><span>您的位置：</span></li>
            <li class="home"><a href="<?= GlobalUrlService::buildSuperMarketUrl("/"); ?>">首页</a></li>
            <li><a href="<?= GlobalUrlService::buildSuperMarketUrl("/default/soft"); ?>">软件下载</a></li>
		</ol>
	</div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <section class="panel panel-default articles-index-main">
                <ul class="list-unstyled articles-index-list">
                    <?php foreach( $data as $_item ):?>
                    <li class="index-article-item ">
                        <a class="article-item-image" href="<?=GlobalUrlService::buildSuperMarketUrl("/default/info",[ "id" => $_item['id'] ]);?>">
                            <img src="<?=$_item['image_url'];?>">
                        </a>
                        <div class="article-item-text">
                            <a class="article-item-title" href="<?=GlobalUrlService::buildSuperMarketUrl("/default/info",[ "id" => $_item['id'] ]);?>"><h1><?=$_item['title'];?></h1></a>
                            <p class="article-item-tags">
                                <a href="<?=GlobalUrlService::buildNullUrl();?>" class="article-tag-element"><?=$_item['type_desc'];?></a>
                            </p>
                            <p class="article-item-desc">
								<?=$_item['content'];?>
                            </p>
                            <p class="article-item-options">
                                <span class="article-item-time">发布于：<span><?=$_item['date'];?></span></span>
                                <a href="<?=GlobalUrlService::buildSuperMarketUrl("/default/info",[ "id" => $_item['id'] ]);?>" class="pull-right article-item-more">阅读全文&gt;&gt;</a>
                            </p>
                        </div>
                    </li>
                    <?php endforeach;?>
                </ul>
            </section>
            <section class="paginator-element">
                <ul class="pagination">
                    <?php if( $page_info['previous'] ):?>
                        <li><a href="<?=GlobalUrlService::buildSuperMarketUrl("/default/site",[ "p" => 1 ]);?>" rel="prev">上一页</a></li>
                    <?php endif;?>
                    <?php for( $page_idx = $page_info['from']; $page_idx <= $page_info['end'];$page_idx++):?>
                        <?php if( $page_info['current'] == $page_idx ):?>
                            <li class="active"><span><?=$page_idx;?></span></li>
                        <?php else:?>
                            <li><a href="<?=GlobalUrlService::buildSuperMarketUrl("/default/site",[ "p" => $page_idx ]);?>"><?=$page_idx;?></a></li>
                        <?php endif;?>
                    <?php endfor;?>
					<?php if( $page_info['next'] ):?>
                    <li>
                        <a href="<?=GlobalUrlService::buildSuperMarketUrl("/default/site",[ "p" => $page_info['current'] + 1 ]);?>" rel="next">下一页</a>
                    </li>
					<?php endif;?>
                </ul>
            </section>
        </div>
        <div class="col-sm-4 col-md-3 hide">
            <form method="GET" action="http://www.shafa.com/articles/search" accept-charset="UTF-8" class="article-index-search form-inline">

                <div class="form-group">
                    <input class="form-control" name="kw" type="text">
                </div>
                <button class="btn btn-warning" type="submit">搜索</button>

            </form>
            <section class="panel panel-default side-element">
                <div class="panel-heading">
                    <h3 class="panel-title">本周热门</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-unstyled side-element-list articles-image-list">
                        <li>
                            <a href="<?=GlobalUrlService::buildNullUrl();?>" class="article-item-image" target="_blank" >
                                <div class="article-item-mask">
                                    <img src="<?=GlobalUrlService::buildNullUrl();?>" >
                                </div>
                            </a>
                            <div class="article-item-text">
                                <a href="<?=GlobalUrlService::buildNullUrl();?>">小程序</a>
                                <p>小程序描述</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </section>
            <section class="panel panel-default side-element">
                <div class="panel-heading">
                    <h3 class="panel-title">热门标签</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-inline side-element-list articles-tags-list">
                        <li>
                            <a href="<?=GlobalUrlService::buildNullUrl();?>" class="btn btn-default">小程序</a>
                        </li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
</div>