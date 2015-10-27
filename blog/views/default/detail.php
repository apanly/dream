<?php
use  \common\components\DataHelper;
use \blog\components\StaticService;
use yii\helpers\Url;

StaticService::includeAppJsStatic("/js/web/default/info.js", \blog\assets\AppAsset::className());

StaticService::includeAppJsStatic("http://v3.jiathis.com/code/jia.js?uid=900964",\blog\assets\AppAsset::className());
?>
<main class="col-md-8 main-content">
    <article  class="post tag-zhuti tag-static-page tag-customize-page">
        <header class="post-head">

            <h1 class="post-title"><?=$info['title'];?></h1>
            <section class="post-meta">
                <span class="author">作者：<a href="<?=$info['author']['link'];?>"><?=$info['author']['nickname'];?></a></span> •
                <?php if($info['original']):?>【原创】&bull;<?php endif;?>
                <time class="post-date" ><?=$info['date'];?></time>
            </section>
        </header>

        <section class="post-content">
            <p><?=$info['content'];?></p>
        </section>
        <!-- JiaThis Button BEGIN -->
        <div class="jiathis_style_32x32 clearfix">
            <a class="jiathis_button_qzone"></a>
            <a class="jiathis_button_tsina"></a>
            <a class="jiathis_button_tqq"></a>
            <a class="jiathis_button_weixin"></a>
            <a class="jiathis_button_renren"></a>
            <a href="http://www.jiathis.com/share?uid=900964" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
            <a class="jiathis_counter_style"></a>
        </div>
        <script type="text/javascript">
            var jiathis_config = {data_track_clickback:'true'};
        </script>
        <!-- JiaThis Button END -->
        <?php if($info['tags']):?>
        <footer class="post-footer clearfix">
            <div class="pull-left tag-list">
                <i class="fa fa-folder-open-o"></i>
                <?php foreach($info['tags'] as $_tag):?>
                    <a href="/search/do?kw=<?=$_tag;?>"><?=$_tag;?></a>
                <?php endforeach;?>
            </div>
        </footer>
        <?php endif;?>

    </article>

    <div class="prev-next-wrap clearfix">
        <?php if($prev_info):?>
            <a class="btn btn-default" href="<?=Url::toRoute(["/default/info","id" => $prev_info['id'] ]);?>"><i class="fa fa-angle-left fa-fw"></i> <?=DataHelper::encode($prev_info['title']);?></a>
        <?php endif;?>
        &nbsp;
        <?php if($next_info):?>
            <a class="btn btn-default" href="<?=Url::toRoute(["/default/info","id" => $next_info['id'] ]);?>"><?=DataHelper::encode($next_info['title']);?> <i class="fa fa-angle-right fa-fw"></i></a>
        <?php endif;?>
    </div>


</main>
<?= Yii::$app->controller->renderPartial("/public/side");?>