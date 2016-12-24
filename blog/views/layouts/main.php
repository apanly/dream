<?php
use yii\helpers\Html;
use blog\assets\AppAsset;
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
    <meta name="description" content="<?= DataHelper::encode($this->params['seo']['description']); ?>"/>
    <meta name="keywords" content="<?= DataHelper::encode($this->params['seo']['keywords']); ?>">
    <meta name="HandheldFriendly" content="True"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="baidu-site-verification" content="sfWgUvxKJK" />
    <meta name="google-site-verification" content="c_1LAxAX-8MMoXntjVS1kCu5JnGhVIlcgLT6idZpgq4" />
    <meta property="wb:webmaster" content="ccdf2279363f4648" />
    <link rel="shortcut icon" href="<?=GlobalUrlService::buildStaticUrl("/images/icon.png");?>">
    <link rel="icon" href="<?=GlobalUrlService::buildStaticUrl("/images/icon.png");?>">

    <?php $this->head() ?>
    <?php $this->beginBody() ?>
</head>
<body class="home-template">
<?= Yii::$app->controller->renderPartial("/public/header", ["menu" => $this->params['menu']]); ?>
<section class="content-wrap">
    <div class="container">
        <div class="row">
            <?php echo $content ?>
        </div>
    </div>
</section>
<?= Yii::$app->controller->renderPartial("/public/footer", ["copyright" => $this->params["copyright"]]); ?>
<?php $this->endBody() ?>

<?php echo \Yii::$app->view->renderFile("@blog/views/public/stat.php");?>
</body>
</html>
<?php $this->endPage() ?>
