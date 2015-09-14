<?php
use  \common\components\DataHelper;
?>
<main class="col-md-8 main-content">
    <article  class="post tag-zhuti tag-static-page tag-customize-page">

        <header class="post-head">
            <h1 class="post-title"><?=$info['title'];?></h1>
            <section class="post-meta">
                <span class="author">作者：<a href="<?=$info['author']['link'];?>"><?=$info['author']['nickname'];?></a></span> •
                <time class="post-date" ><?=$info['date'];?></time>
            </section>
        </header>


        <section class="post-content">
            <p><?=$info['content'];?></p>
        </section>
        <?php if($info['tags']):?>
        <footer class="post-footer clearfix">
            <div class="pull-left tag-list">
                <i class="fa fa-folder-open-o"></i>
                <?php foreach($info['tags'] as $_tag):?>
                    <a href="/search/tag?kw=<?=$_tag;?>"><?=$_tag;?></a>
                <?php endforeach;?>
            </div>
        </footer>
        <?php endif;?>

    </article>

    <div class="prev-next-wrap clearfix">
        <?php if($prev_info):?>
            <a class="btn btn-default" href="/default/<?=$prev_info['id'];?>"><i class="fa fa-angle-left fa-fw"></i> <?=DataHelper::encode($prev_info['title']);?></a>
        <?php endif;?>
        &nbsp;
        <?php if($next_info):?>
            <a class="btn btn-default" href="/default/<?=$next_info['id'];?>"><?=DataHelper::encode($next_info['title']);?> <i class="fa fa-angle-right fa-fw"></i></a>
        <?php endif;?>
    </div>


</main>
<?= Yii::$app->controller->renderPartial("/public/side");?>