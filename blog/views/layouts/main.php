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
    <meta name="description"
          content="Ghost 是一套基于 Node.js 构建的开源博客平台（Open source blogging platform），具有易用的书写界面和体验，博客内容默认采用 Markdown 语法书写，目标是取代臃肿的 Wordpress。"/>
    <meta name="keywords" content="Ghost,blog,Ghost中国,Ghost博客,Ghost中文,Ghost中文文档">

    <meta name="HandheldFriendly" content="True"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="/favicon.ico">
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
