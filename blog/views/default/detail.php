<?php
use  \common\components\DataHelper;
use \blog\components\StaticService;
use yii\helpers\Url;
use blog\components\UrlService;

/*lightbox*/
StaticService::includeStaticCss("/jquery/lightbox2/css/lightbox.css",\blog\assets\AppAsset::className());
StaticService::includeStaticJs("/jquery/lightbox2/js/lightbox.min.js",\blog\assets\AppAsset::className());

/*syntaxhighlighter*/
StaticService::includeStaticJs("/syntaxhighlighter/scripts/shCore.js",\blog\assets\AppAsset::className());
StaticService::includeStaticJs("/syntaxhighlighter/scripts/shAutoloader.js",\blog\assets\AppAsset::className());
StaticService::includeStaticCss("/syntaxhighlighter/styles/shCore.css",\blog\assets\AppAsset::className());
StaticService::includeStaticCss("/syntaxhighlighter/styles/shThemeDefault.css",\blog\assets\AppAsset::className());


StaticService::includeAppJsStatic("/js/web/default/info.js", \blog\assets\AppAsset::className());
StaticService::includeAppJsStatic("/js/duoshuo.js", \blog\assets\AppAsset::className());
StaticService::includeAppJsStatic("http://v3.jiathis.com/code/jia.js?uid=900964", \blog\assets\AppAsset::className());
?>
<main class="col-md-8 main-content">
    <article class="post tag-zhuti tag-static-page tag-customize-page">
        <header class="post-head">

            <h1 class="post-title"><?= $info['title']; ?></h1>
            <section class="post-meta">
                <span class="author">作者：<a
                        href="<?= $info['author']['link']; ?>"><?= $info['author']['nickname']; ?></a></span> &bull;
                <?php if ($info['original']): ?>
                    <span class="label label-success">原创</span>&bull;
                <?php endif; ?>
                <time class="post-date"><?= $info['date']; ?></time>
            </section>
        </header>

        <section class="post-content">
            <p><?= $info['content']; ?></p>
        </section>
        <div class="page-header">
            版权声明：本文为博主原创文章，原文永久地址：<?= $info['url']; ?>
        </div>

        <!-- JiaThis Button BEGIN -->
        <div class="jiathis_style_32x32 clearfix">
            <a class="jiathis_button_qzone"></a>
            <a class="jiathis_button_tsina"></a>
            <a class="jiathis_button_tqq"></a>
            <a class="jiathis_button_weixin"></a>
            <a class="jiathis_button_renren"></a>
            <a href="http://www.jiathis.com/share?uid=900964" class="jiathis jiathis_txt jtico jtico_jiathis"
               target="_blank"></a>
            <a class="jiathis_counter_style"></a>
        </div>
        <script type="text/javascript">
            var jiathis_config = {data_track_clickback: 'true'};
        </script>
        <!-- JiaThis Button END -->
        <?php if ($info['tags']): ?>
            <footer class="post-footer clearfix">
                <div class="pull-left tag-list">
                    <i class="glyphicon glyphicon-tags"></i>
                    <?php foreach ($info['tags'] as $_tag): ?>
                        <a href="/search/do?kw=<?= $_tag; ?>"><?= $_tag; ?></a>
                    <?php endforeach; ?>
                </div>
            </footer>
        <?php endif; ?>

        <!-- 多说评论框 start -->
        <div class="ds-thread" data-thread-key="<?= $info['id']; ?>" data-title="<?= $info['title']; ?>"
             data-url="<?= $info['url']; ?>"></div>
        <!-- 多说评论框 end -->
    </article>

    <div class="prev-next-wrap clearfix">
        <?php if ($prev_info): ?>
            <a class="btn btn-default" href="<?= UrlService::buildUrl("/default/info", ["id" => $prev_info['id'],"flag"=>"prev" ]); ?>"><i
                    class="fa fa-angle-left fa-fw"></i> <?= DataHelper::encode($prev_info['title']); ?></a>
        <?php endif; ?>
        &nbsp;
        <?php if ($next_info): ?>
            <a class="btn btn-default"
               href="<?= UrlService::buildUrl("/default/info", [ "id" => $next_info['id'],"flag" => "next" ]); ?>"><?= DataHelper::encode($next_info['title']); ?>
                <i class="fa fa-angle-right fa-fw"></i></a>
        <?php endif; ?>
    </div>


</main>
<?= Yii::$app->controller->renderPartial("/public/blog_side",[ "recommend_blogs" => $recommend_blogs]); ?>

<!-- 多说公共JS代码 start (一个网页只需插入一次) -->
<script type="text/javascript">
    var duoshuoQuery = {short_name: "guowei"};
    (function () {
        var ds = document.createElement('script');
        ds.type = 'text/javascript';
        ds.async = true;
        ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
        ds.charset = 'UTF-8';
        (document.getElementsByTagName('head')[0]
            || document.getElementsByTagName('body')[0]).appendChild(ds);
    })();
</script>
<!-- 多说公共JS代码 end -->