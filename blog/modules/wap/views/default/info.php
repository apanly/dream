<?php
use blog\components\StaticService;
use \common\service\GlobalUrlService;
StaticService::includeStaticCss("/jquery/lightbox2/css/lightbox.css",\blog\assets\WapAsset::className());
StaticService::includeStaticJs("/jquery/lightbox2/js/lightbox.min.js",\blog\assets\WapAsset::className());

StaticService::includeAppJsStatic("/js/wap/default/info.js", \blog\assets\WapAsset::className());
StaticService::includeStaticJs("/js/duoshuo/duoshuo.js", \blog\assets\WapAsset::className());

$wx_url = GlobalUrlService::buildStaticUrl("/images/weixin/m_imguowei_888.gif",['w' => 300]);
?>
<div class="am-paragraph am-paragraph-default">
    <article class="am-article">
        <div class="am-article-hd">
            <h1 class="am-article-title"><?= $info["title"]; ?></h1>

            <p class="am-article-meta">
                作者：<?= $info["author"]['nickname']; ?>
                更新时间：<?= $info['date']; ?>
            </p>
        </div>
        <hr data-am-widget="divider" style="" class="am-divider am-divider-default"/>
        <div class="am-article-bd">
            <?= $info["content"]; ?>
        </div>
        <hr data-am-widget="divider" style="" class="am-divider am-divider-default"/>
        <figure data-am-widget="figure" class="am am-figure am-figure-default am-no-layout">
            <img src="<?=$wx_url;?>" alt="微信服务号：imguowei_888">
        </figure>
        <!-- 多说评论框 start -->
        <div class="ds-thread" data-thread-key="<?= $info['id']; ?>" data-title="<?= $info['title']; ?>"
             data-url="<?= $info['url']; ?>"></div>
        <!-- 多说评论框 end -->
    </article>
</div>

