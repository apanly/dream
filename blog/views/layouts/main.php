<?php
use yii\helpers\Html;
use blog\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="description" content="郭大帅哥的梦平台，一个有梦的php开发工程师"/>
    <meta name="keywords" content="郭大帅哥的梦平台，一个有梦的php开发工程师">

    <meta name="HandheldFriendly" content="True"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="google-site-verification" content="c_1LAxAX-8MMoXntjVS1kCu5JnGhVIlcgLT6idZpgq4" />
    <?php $this->head() ?>
    <?php $this->beginBody() ?>
    <script>
        var sidebar_left = false;
        var recent_post_count = 3;
    </script>
</head>
<body class="home-template">
<?= Yii::$app->controller->renderPartial("/public/header",["menu" => $this->params['menu']]);?>
<section class="content-wrap">
    <div class="container">
        <div class="row">
            <?php echo $content ?>
        </div>
    </div>
</section>
<?= Yii::$app->controller->renderPartial("/public/footer",["copyright" => $this->params["copyright"]]);?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
