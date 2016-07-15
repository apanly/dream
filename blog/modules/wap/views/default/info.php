<?php
use blog\components\StaticService;
use \common\service\GlobalUrlService;
use \blog\components\UrlService;
StaticService::includeStaticCss("/jquery/lightbox2/css/lightbox.css",\blog\assets\WapAsset::className());
StaticService::includeStaticJs("/jquery/lightbox2/js/lightbox.min.js",\blog\assets\WapAsset::className());

StaticService::includeStaticCss("/prettify/prettify.sons.css",\blog\assets\WapAsset::className());
StaticService::includeStaticJs("/prettify/prettify.js",\blog\assets\WapAsset::className());

StaticService::includeAppJsStatic("/js/wap/default/info.js", \blog\assets\WapAsset::className());
//StaticService::includeStaticJs("/js/duoshuo/duoshuo.js", \blog\assets\WapAsset::className());

$wx_url = GlobalUrlService::buildStaticUrl("/images/weixin/m_imguowei_888.gif",['w' => 300]);
?>
<div class="am-paragraph am-paragraph-default">
    <article class="am-article">
        <div class="am-article-hd">
            <h1 class="am-article-title"><?= $info["title"]; ?></h1>
            <p class="am-article-meta">
                作者：<?= $info["author"]['nickname']; ?><br/>
                <?php if( $info['updated_date'] != $info['created_date'] ):?>
                更新时间：<?= $info['updated_date']; ?><br/>
                <?php endif;?>
                创建时间：<?= $info['created_date']; ?>
            </p>
        </div>
        <hr data-am-widget="divider" style="" class="am-divider am-divider-default"/>
        <div class="am-article-bd">
            <?= $info["content"]; ?>
        </div>
        <?php if( $info['tags'] ):?>
        <div class="am-article-bd">
            <i class="am-icon-tags"></i>
            <?php foreach( $info['tags'] as $_tag ):?>
                <a href="<?=UrlService::buildWapUrl("/search/do",['kw' => $_tag]);?>"><?=$_tag;?></a>
            <?php endforeach;?>
        </div>
        <?php endif;?>
        <div class="am-panel am-panel-default" style="margin-top: 10px;">
            <div class="am-panel-hd">智能推荐</div>
            <ul class="am-list">
                <?php foreach( $recommend_blogs as $_recommend_blog_info ):?>
                <li>
                    <a href="<?=UrlService::buildWapUrl("/default/info",[ "id" => $_recommend_blog_info["id"],"flag" => "recommend" ]);?>"><?=$_recommend_blog_info["title"];?></a>
                </li>
                <?php endforeach;?>
            </ul>
        </div>

        <div class="am-article-bd text-right" style="display: none;">
            <i class="am-icon-btn am-warning  am-icon-thumbs-up"></i>
            喜欢
        </div>
        <hr data-am-widget="divider" style="display: none;" class="am-divider am-divider-default"/>
        <figure data-am-widget="figure" class="am am-figure am-figure-default am-no-layout">
            <img src="<?=$wx_url;?>" alt="微信服务号：imguowei_888">
        </figure>
        <!-- 多说评论框 start -->
        <div class="ds-thread" data-thread-key="<?= $info['id']; ?>" data-title="<?= $info['title']; ?>"
             data-url="<?= $info['url']; ?>"></div>
        <!-- 多说评论框 end -->
    </article>
</div>

