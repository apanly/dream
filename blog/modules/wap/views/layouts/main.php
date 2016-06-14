<?php
use blog\assets\WapAsset;
use blog\components\StaticService;
use \common\service\GlobalUrlService;
use  \common\components\DataHelper;

WapAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="description" content="<?= DataHelper::encode($this->params['seo']['description']); ?>"/>
    <meta name="keywords" content="<?= DataHelper::encode($this->params['seo']['keywords']); ?>">
    <title><?= DataHelper::encode($this->title) ?></title>
    <meta name="HandheldFriendly" content="True"/>
    <meta name="google-site-verification" content="c_1LAxAX-8MMoXntjVS1kCu5JnGhVIlcgLT6idZpgq4" />
    <link rel="shortcut icon" href="<?=GlobalUrlService::buildStaticUrl("/images/icon.png");?>">
    <link rel="icon" href="<?=GlobalUrlService::buildStaticUrl("/images/icon.png");?>">
    <?php $this->head() ?>
    <?php $this->beginBody() ?>
</head>
<body>
<div class="am-g">
    <section>
        <?php echo $content ?>
    </section>
    <?= Yii::$app->controller->renderPartial("/public/footer"); ?>
</div>
<?php $this->endBody() ?>
<div style="display:none">
    <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1259302647'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/z_stat.php%3Fid%3D1259302647%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>
</div>
</body>
</html>
<?php $this->endPage() ?>
