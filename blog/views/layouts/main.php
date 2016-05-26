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
<div style="display:none">
    <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1259302647'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/z_stat.php%3Fid%3D1259302647%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>
</div>
</body>
</html>
<?php $this->endPage() ?>
