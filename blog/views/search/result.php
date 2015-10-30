<main class="col-md-8 main-content">
    <?php if ($data): ?>
        <?php foreach ($data as $_item): ?>
            <article class="post tag-about-ghost tag-release featured">
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
                        <time class="post-date">发布时间： <?= $_item['date']; ?></time>
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
                            <i class="fa fa-folder-open-o"></i>
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
    <?php else: ?>
        <div class="cover tag-cover">
            <h3 class="tag-name">
                抱歉,没有找到相关文章
            </h3>
        </div>
    <?php endif; ?>

    <?php if ($page_info['total_page']): ?>
        <nav class="pagination" role="navigation">
            <?php if ($page_info['previous']): ?>
                <a class="newer-posts" href="<?= $urls['page_base'] . "&p=" . ($page_info['current'] - 1); ?>"><i
                        class="fa fa-angle-left"></i></a>
            <?php endif; ?>
            <span class="page-number">第 <?= $page_info['current']; ?> 页 &frasl; 共 <?= $page_info['total_page']; ?>
                页</span>
            <?php if ($page_info['next']): ?>
                <a class="older-posts" href="<?= $urls['page_base'] . "&p=" . ($page_info['current'] + 1); ?>"><i
                        class="fa fa-angle-right"></i></a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>

</main>
<?= Yii::$app->controller->renderPartial("/public/side"); ?>

