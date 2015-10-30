<?php
use  \common\components\DataHelper;

?>
<main class="col-md-12 main-content">
    <article class="post tag-zhuti tag-static-page tag-customize-page">
        <header class="post-head">
            <h1 class="post-title"><?= $info['title']; ?></h1>
            <h4><?= $info['name']; ?></h4>
            <section class="post-meta">
                <span class="author">作者：<?= $info['author']; ?></span> •
                <span class="post-date">出版时间：<?= $info['publish_date']; ?></span>
            </section>
        </header>


        <section class="post-content">
            <p style="text-align: center;">
                <img src="<?= $info['image_url']; ?>"/>
            </p>

            <p><?= $info['summary']; ?></p>
        </section>
        <?php if ($info['tags']): ?>
            <footer class="post-footer clearfix">
                <div class="pull-left tag-list">
                    <i class="fa fa-folder-open-o"></i>
                    <?php foreach ($info['tags'] as $_tag): ?>
                        <a href="/search/do?kw=<?= $_tag; ?>"><?= $_tag; ?></a>
                    <?php endforeach; ?>
                </div>
            </footer>
        <?php endif; ?>

    </article>

    <div class="prev-next-wrap clearfix">
        <?php if ($prev_info): ?>
            <a class="btn btn-default" href="/library/detail/<?= $prev_info['id']; ?>"><i
                    class="fa fa-angle-left fa-fw"></i> <?= DataHelper::encode($prev_info['subtitle']); ?></a>
        <?php endif; ?>
        &nbsp;
        <?php if ($next_info): ?>
            <a class="btn btn-default"
               href="/library/detail/<?= $next_info['id']; ?>"><?= DataHelper::encode($next_info['subtitle']); ?> <i
                    class="fa fa-angle-right fa-fw"></i></a>
        <?php endif; ?>
    </div>


</main>