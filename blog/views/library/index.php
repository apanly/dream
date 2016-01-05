<?php
use \yii\helpers\Url;
?>
<main class="col-md-12 main-content">
    <article class="post page">
        <div class="row" style="text-align: center;margin-bottom: 5px;">
            <h3>读书好 -- 重新认识自己</h3>
        </div>
        <?php if ($data): ?>
            <div class="row">
                <?php foreach ($data as $_item): ?>
                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail" title="<?= $_item['title']; ?>" style="position: relative">
                            <a href="<?= $_item['view_url']; ?>">
                                <img src="<?= $_item['imager_url']; ?>" style="height: 200px; width: 100%; display: block;">
                            </a>
                            <img src="<?= $_item['icon_imager_url']; ?>" style="position: absolute;top: 0px;left:0px;">

                            <div class="caption">
                                <h4><?= $_item['short_title']; ?></h4>
                                <h5><?= $_item['author']; ?></h5>
                                <p>
                                    <a href="<?= $_item['view_url']; ?>" class="btn btn-default">查看详情</a>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </article>
    <?php if ($page_info['total_page']): ?>
        <nav class="pagination" role="navigation">
            <?php if ($page_info['previous']): ?>
                <a class="newer-posts" href="<?= Url::toRoute("/library/index?p=" . ($page_info['current'] - 1)); ?>"><i
                        class="fa fa-angle-left"></i></a>
            <?php endif; ?>
            <span class="page-number">第 <?= $page_info['current']; ?> 页 &frasl; 共 <?= $page_info['total_page']; ?>
                页</span>
            <?php if ($page_info['next']): ?>
                <a class="older-posts" href="<?= Url::toRoute("/library/index?p=" . ($page_info['current'] + 1)); ?>"><i
                        class="fa fa-angle-right"></i></a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
</main>