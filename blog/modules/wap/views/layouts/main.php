<?php
use blog\assets\WapAsset;
use blog\components\StaticService;
use  \common\components\DataHelper;
WapAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <meta name="format-detection" content="telephone=no" searchtype="map">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <title><?=DataHelper::encode($this->title)?></title>
        <?php $this->head() ?>
        <?php $this->beginBody()?>
    </head>
    <body>
    <div class="am-g">
        <section>
            <?php echo $content ?>
        </section>
        <?= Yii::$app->controller->renderPartial("/public/footer");?>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
