<?php
use blog\assets\MarketAsset;
use blog\components\UrlService;
use blog\components\StaticService;
use  \common\components\DataHelper;
use \common\service\GlobalUrlService;
MarketAsset::register($this);
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
    <link rel="shortcut icon" href="<?=GlobalUrlService::buildStaticUrl("/images/icon.png");?>">
    <link rel="icon" href="<?=GlobalUrlService::buildStaticUrl("/images/icon.png");?>">
    <title><?=DataHelper::encode($this->title)?></title>
    <?php $this->head() ?>
    <?php $this->beginBody()?>
</head>
<body class="wechatwall">
<div class="wechatwall_top">
    <div class="logo">
        <div class="inner">
            <img src="<?=$this->params['logo']?>" alt="" />
        </div>
    </div>
    <h1 class="title"><?=DataHelper::encode($this->title)?></h1>
</div>
<div class="wrap">
    <?php echo $content ?>
</div>

<?php $this->endBody() ?>
<div style="display:none">
    <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1259302647'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/z_stat.php%3Fid%3D1259302647%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>
</div>
</body>
</html>
<?php $this->endPage() ?>
