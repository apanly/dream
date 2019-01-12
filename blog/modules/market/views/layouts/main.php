<?php
use blog\assets\SuperMarketAsset;
use \common\service\GlobalUrlService;
use  \common\components\DataHelper;
SuperMarketAsset::register($this);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="<?= GlobalUrlService::buildStaticUrl("/images/supermarket/icon.png"); ?>">
    <link rel="icon" href="<?= GlobalUrlService::buildStaticUrl("/images/supermarket/icon.png"); ?>">
    <title><?= DataHelper::encode($this->title) ?></title>
    <meta name="keywords" content="php网站源码,企业网站源码,手机网站源码,网站源码下载,VIP源码下载" />
    <meta name="description" content="网站源码频道提供大量的php源码,高质量免费网站源码,免费vip源码下载,PHP源码,JSP源码,HTML源码,企业网站源码,手机网站源码VIP源码下载，供大家免费下载，所有源码都经过详细测试后才分享 " />
    <?php $this->head() ?>
    <?php $this->beginBody() ?>
</head>
<body>
<?= Yii::$app->controller->renderPartial("@blog/modules/market/views/layouts/header", [  ]); ?>
<div class="container-fluid" style="padding: 0;min-height: 600px;">
<?= $content; ?>
</div>
<?= Yii::$app->controller->renderPartial("@blog/modules/market/views/layouts/footer", [  ]); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>