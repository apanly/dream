<?php
use yii\helpers\Html;
use admin\assets\AppAsset;
use admin\components\StaticService;
use yii\helpers\Url;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <?php $this->head() ?>
    <?php $this->beginBody() ?>
</head>
<body>
<div class="page-container">
    <div class="page-sidebar">
        <ul class="x-navigation">
            <?= Yii::$app->controller->renderPartial("/public/user_info");?>
            <li class="menu_dashboard">
                <a href="<?=Url::toRoute("/default/index");?>">
                    <span class="fa fa-desktop"></span>
                    <span class="xn-text">Dashboard</span>
                </a>
            </li>
            <li class="xn-openable menu_posts">
                <a href="javascript:void(0);">
                    <span class="fa fa-cogs"></span><span class="xn-text">文章管理</span>
                </a>
                <ul>
                    <li><a href="<?=Url::toRoute("/posts/index");?>"><span class="fa fa-heart"></span>文章列表</a></li>
                    <li><a href="<?=Url::toRoute("/posts/comments");?>"><span class="fa fa-square-o"></span> 评论管理</a></li>
                </ul>
            </li>
            <li class="xn-openable menu_library">
                <a href="javascript:void(0);">
                    <span class="fa fa-cogs"></span><span class="xn-text">图书管理</span>
                </a>
                <ul>
                    <li><a href="<?=Url::toRoute("/library/index");?>"><span class="fa fa-heart"></span>图书列表</a></li>
                </ul>
            </li>
            <li class="xn-openable menu_doubanmz">
                <a href="javascript:void(0);">
                    <span class="fa fa-cogs"></span><span class="xn-text">豆瓣妹纸</span>
                </a>
                <ul>
                    <li><a href="<?=Url::toRoute("/douban/mz");?>"><span class="fa fa-heart"></span>妹纸列表</a></li>
                </ul>
            </li>
        </ul>
        <!-- END X-NAVIGATION -->
    </div>
    <div class="page-content">

        <!-- START X-NAVIGATION VERTICAL -->
        <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
            <!-- TOGGLE NAVIGATION -->
            <li class="xn-icon-button">
                <a href="javascript:void(0);" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
            </li>
            <!-- END TOGGLE NAVIGATION -->
            <!-- SEARCH -->
            <li class="xn-search">
                <form role="form">
                    <input type="text" name="search" placeholder="Search..."/>
                </form>
            </li>
            <!-- END SEARCH -->
            <!-- SIGN OUT -->
            <li class="xn-icon-button pull-right">
                <a href="<?=Url::toRoute("/auth/loginout");?>" class="mb-control"><span class="fa fa-sign-out"></span></a>
            </li>
            <!-- END SIGN OUT -->
            <!-- MESSAGES -->
            <li class="xn-icon-button pull-right">
                <a href="javascript:void(0);"><span class="fa fa-comments"></span></a>
                <div class="informer informer-danger">4</div>
            </li>
            <!-- END MESSAGES -->
            <!-- TASKS -->
            <li class="xn-icon-button pull-right">
                <a href="javascript:void(0);"><span class="fa fa-tasks"></span></a>

                <div class="informer informer-warning">3</div>
            </li>
            <!-- END TASKS -->
        </ul>
        <!-- END X-NAVIGATION VERTICAL -->
    <?php echo $content; ?>
    </div>
</div>
<?php $this->endBody() ?>

<script src="/js/public.js"></script>
</body>
</html>
<?php $this->endPage() ?>





