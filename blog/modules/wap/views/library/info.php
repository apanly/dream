<?php
use blog\components\StaticService;
StaticService::includeAppJsStatic("/js/wap/library/info.js", \blog\assets\WapAsset::className());
?>
<div class="am-paragraph am-paragraph-default">
    <article class="am-article">
        <div class="am-article-hd">
            <h1 class="am-article-title"><?= $info["title"]; ?></h1>

            <p class="am-article-meta">
                作者：<?= $info["author"]; ?>
                出版时间：<?= $info['publish_date']; ?>
            </p>
        </div>
        <hr data-am-widget="divider" style="" class="am-divider am-divider-default"/>
        <div class="am-article-bd">
            <figure data-am-widget="figure" class="am am-figure am-figure-default ">
                <img data-src="<?= $info["image_url"]; ?>" alt="<?= $info["title"]; ?>"/>
            </figure>
            <?= $info["summary"]; ?>
        </div>
    </article>
</div>