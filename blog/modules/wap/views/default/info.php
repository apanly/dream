<?php
use blog\components\StaticService;
StaticService::includeAppJsStatic("/js/wap/default/info.js",\blog\assets\WapAsset::className());
StaticService::includeAppJsStatic("/js/duoshuo.js",\blog\assets\WapAsset::className());
?>
<div class="am-paragraph am-paragraph-default">
    <article class="am-article">
        <div class="am-article-hd">
            <h1 class="am-article-title"><?=$info["title"];?></h1>
            <p class="am-article-meta">
                作者：<?=$info["author"]['nickname'];?>
                更新时间：<?=$info['date'];?>
            </p>
        </div>
        <hr data-am-widget="divider" style="" class="am-divider am-divider-default" />
        <div class="am-article-bd">
            <?=$info["content"];?>
        </div>
        <!-- 多说评论框 start -->
        <div class="ds-thread" data-thread-key="<?=$info['id'];?>" data-title="<?=$info['title'];?>" data-url="<?=$info['url'];?>"></div>
        <!-- 多说评论框 end -->
    </article>
</div>

