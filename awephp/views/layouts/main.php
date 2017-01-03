<?php
use yii\helpers\Html;
use awephp\assets\AppAsset;
use \common\service\GlobalUrlService;
use \common\components\DataHelper;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title><?= DataHelper::encode($this->title) ?></title>
    <meta name="HandheldFriendly" content="True"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="<?= GlobalUrlService::buildStaticPic("/images/awephp/icon.png"); ?>">
    <link rel="icon" href="<?= GlobalUrlService::buildStaticPic("/images/awephp/icon.png"); ?>">
	<?php $this->head() ?>
	<?php $this->beginBody() ?>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top site-navbar">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?=GlobalUrlService::buildPhpUrl("/");?>">AwePHP教程</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="<?=GlobalUrlService::buildPhpUrl("/");?>">首页</a>
                </li>
                <li>
                    <a href="<?=GlobalUrlService::buildPhpUrl("/docs/info",[  'id' => 1 ]);?>">教程</a>
                </li>
                <li>
                    <a href="<?=GlobalUrlService::buildBlogUrl("/");?>">博客</a>
                </li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>

<div class="content">
	<?php echo $content ?>
</div>

<?= Yii::$app->controller->renderPartial("/public/footer"); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
