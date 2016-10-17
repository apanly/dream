<?php
use yii\helpers\Html;
use admin\assets\AppAsset;
use admin\components\StaticService;
use \common\service\GlobalUrlService;
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
    <link rel="shortcut icon" href="<?=GlobalUrlService::buildStaticUrl("/images/icon.png");?>">
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
            <li class="xn-openable menu_account">
                <a href="javascript:void(0);">
                    <span class="fa fa-cogs"></span><span class="xn-text">账号管理</span>
                </a>
                <ul>
                    <li><a href="<?=Url::toRoute("/account/index");?>"><span class="fa fa-heart"></span>账号列表</a></li>
                </ul>
            </li>
            <li class="xn-openable menu_richmedia">
                <a href="javascript:void(0);">
                    <span class="fa fa-cogs"></span><span class="xn-text">多媒体管理</span>
                </a>
                <ul>
                    <li><a href="<?=Url::toRoute("/richmedia/index");?>"><span class="fa fa-heart"></span>多媒体列表</a></li>
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
            <li class="xn-openable menu_file">
                <a href="javascript:void(0);">
                    <span class="fa fa-cogs"></span><span class="xn-text">文件管理</span>
                </a>
                <ul>
                    <li>
                        <a href="<?=Url::toRoute("/file/index");?>">
                            <span class="fa fa-heart"></span>文件列表
                        </a>
                    </li>
                </ul>
            </li>
            <li class="xn-openable menu_log">
                <a href="javascript:void(0);">
                    <span class="fa fa-cogs"></span><span class="xn-text">统计管理</span>
                </a>
                <ul>
                    <li>
                        <a href="<?=Url::toRoute("/log/access");?>">
                            <span class="fa fa-heart"></span>访问日志
                        </a>
                    </li>
                    <li>
                        <a href="<?=Url::toRoute("/log/uuid");?>">
                            <span class="fa fa-heart"></span>UUID统计
                        </a>
                    </li>
                    <li>
                        <a href="<?=Url::toRoute("/log/source");?>">
                            <span class="fa fa-heart"></span>来源统计
                        </a>
                    </li>
                    <li>
                        <a href="<?=Url::toRoute("/log/app");?>">
                            <span class="fa fa-heart"></span>错误日志
                        </a>
                    </li>
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





