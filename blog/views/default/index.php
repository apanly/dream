<?php
use \yii\helpers\Url;
use \blog\components\StaticService;
use \blog\components\UrlService;

StaticService::includeAppJsStatic("/js/web/default/index.js", \blog\assets\AppAsset::className());
?>
<style type="text/css">
    #short_cut a {
        padding: 5px 5px;
    }
</style>

<div class="col-md-12" id="short_cut">
    <div class="panel panel-default">
        <div class="panel-body" style="padding: 5px 5px;">
            <div class="row">
                <div class="col-md-8">
                    <a class="pull-left" href="<?= UrlService::buildUrl("/default/index", ["type" => 1]); ?>">文章列表</a>
                    <a class="pull-left" href="<?= UrlService::buildUrl("/default/index", ["type" => 2]); ?>">热门文章</a>
                    <a class="pull-left" href="<?= UrlService::buildUrl("/default/index", ["type" => 3]); ?>">原创文章</a>
                </div>
                <div class="col-md-4">
                    <?php foreach ($hot_kws as $_kw): ?>
                        <a href="/search/do?kw=<?= $_kw; ?>" class="pull-right"><?= $_kw; ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</div>
<main class="col-md-8 main-content">
    <?php if ($data): ?>
        <?php foreach ($data as $_item): ?>
            <article id=85 class="post tag-about-ghost tag-release featured">
                <div class="featured" title="推荐文章">
                    <i class="fa fa-star"></i>
                </div>

                <div class="post-head">
                    <h1 class="post-title">
                        <a href="<?= $_item['view_url']; ?>">
                            <?= $_item['title']; ?>
                        </a>
                    </h1>

                    <div class="post-meta">
                        <span class="author">作者：<a
                                href="<?= $_item['author']['link']; ?>"><?= $_item['author']['nickname']; ?></a></span> &bull;
                        <?php if ($_item['original']): ?>
                            <span class="label label-success">原创</span>&bull;
                        <?php endif; ?>
                        <time class="post-date"><?= $_item['date']; ?></time>&bull;
                        <span class="author"><?=$_item['view_count'];?>次阅读</span>
                    </div>
                </div>
                <div class="post-content">
                    <p><?= $_item['content']; ?></p>
                </div>
                <div class="post-permalink">
                    <a href="<?= $_item['view_url']; ?>" class="btn btn-default">阅读全文</a>
                </div>
                <?php if ($_item['tags']): ?>
                    <footer class="post-footer clearfix">
                        <div class="pull-left tag-list">
                            <i class="glyphicon glyphicon-tags"></i>
                            <?php foreach ($_item['tags'] as $_tag): ?>
                                <a href="/search/do?kw=<?= $_tag; ?>"><?= $_tag; ?></a>
                            <?php endforeach; ?>
                        </div>
                        <div class="pull-right share">
                        </div>
                    </footer>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if ($page_info['total_page']): ?>
        <nav class="pagination" role="navigation">
            <?php if ($page_info['previous']): ?>
                <a class="newer-posts"
                   href="<?= UrlService::buildUrl("/default/index", ["type" => $type, "p" => ($page_info['current'] - 1)]); ?>"
                   title="上一页"><i class="fa fa-angle-left"></i></a>
            <?php endif; ?>
            <span class="page-number">第 <?= $page_info['current']; ?> 页 &frasl; 共 <?= $page_info['total_page']; ?>
                页</span>
            <?php if ($page_info['next']): ?>
                <a class="older-posts"
                   href="<?= UrlService::buildUrl("/default/index", ["type" => $type, "p" => ($page_info['current'] + 1)]); ?>"
                   title="下一页"><i class="fa fa-angle-right"></i></a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>

</main>
<?= Yii::$app->controller->renderPartial("/public/side"); ?>

