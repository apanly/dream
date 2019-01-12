<?php

use blog\assets\OauthAsset;
use \common\service\GlobalUrlService;
use \common\components\DataHelper;

OauthAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title><?= DataHelper::encode($this->title) ?></title>
    <meta name="description" content="<?= DataHelper::encode($this->params['seo']['description']); ?>"/>
    <meta name="keywords" content="<?= DataHelper::encode($this->params['seo']['keywords']); ?>">
    <meta name="HandheldFriendly" content="True"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="<?= GlobalUrlService::buildStaticUrl("/images/oauth/icon.png"); ?>">
    <link rel="icon" href="<?= GlobalUrlService::buildStaticUrl("/images/oauth/icon.png"); ?>">
	<?php $this->head() ?>
	<?php $this->beginBody() ?>
</head>
<body>
<nav class="navbar navbar-inverse nav-bar-element navbar-fixed-top" style="border-radius:0;">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-menu"
                    aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand"  style="padding: 0;" href="<?= GlobalUrlService::buildNullUrl(); ?>">
                <img src="<?= GlobalUrlService::buildStaticUrl("/images/oauth/logo.png"); ?>"/>
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="nav-menu">
            <ul class="nav navbar-nav">
                <li><a href="<?= GlobalUrlService::buildBlogUrl("/"); ?>">博客</a></li>
                <li><a href="<?= GlobalUrlService::buildSuperMarketUrl("/"); ?>">浪子商城</a></li>
                <li><a href="<?= GlobalUrlService::buildBlogUrl("/demo"); ?>">演示系统</a></li>
                <li><a href="<?= GlobalUrlService::buildGameUrl("/"); ?>">小工具</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="container-fluid">
    <div class="row">
		<?=$content;?>
    </div>
</div>
<?php $this->endBody() ?>

<?php echo \Yii::$app->view->renderFile("@blog/views/public/stat.php"); ?>
</body>
</html>
<?php $this->endPage() ?>
