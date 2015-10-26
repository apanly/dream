<?php
use yii\helpers\Html;
use blog\assets\AppAsset;
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
    <meta name="description" content="<?=DataHelper::encode($this->params['seo']['description']);?>"/>
    <meta name="keywords" content="<?=DataHelper::encode($this->params['seo']['keywords']);?>">
    <meta name="HandheldFriendly" content="True"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="360-site-verification" content="8176f6da55b63a5c0afc481b8d80d4d0" />
    <link rel="shortcut icon" href="/images/icon.png">

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
