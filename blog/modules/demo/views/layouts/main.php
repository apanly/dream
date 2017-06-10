<?php
use blog\assets\DemoAsset;
use blog\components\StaticService;
use \common\service\GlobalUrlService;
use  \common\components\DataHelper;

DemoAsset::register($this);
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
	<link rel="shortcut icon" href="<?=GlobalUrlService::buildStaticUrl("/images/icon.png");?>">
	<link rel="icon" href="<?=GlobalUrlService::buildStaticUrl("/images/icon.png");?>">
	<?php $this->head() ?>
	<?php $this->beginBody() ?>
</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand hidden-sm" href="<?=GlobalUrlService::buildDemoUrl("/");?>">演示系统</a>
        </div>
        <div class="navbar-collapse collapse" role="navigation">
            <ul class="nav navbar-nav">
                <li><a href="<?=GlobalUrlService::buildBlogUrl("/");?>" target="_blank">博客</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="bc-social" style="margin-top: 15px;">
    <div class="container">
        <ul class="bc-social-buttons">
            <li class="social-forum">
                <p>QQ群：325264502 <a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=d7ed56eea3e6e0047db0420404dd0874c5c3d37e30ee40ab7bb6a5a2fb77dc72"><img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="编程浪子小天地" title="编程浪子小天地"></a> </p>
            </li>
            <li class="social-weibo">
                微信公众号：<a  href="<?=\common\service\GlobalUrlService::buildNullUrl();?>" data-toggle="modal" data-target="#wechat_service_qrcode">CodeRonin（点我扫码）</a>
            </li>
        </ul>
    </div>
</div>

<?=$content;?>

<footer class="footer ">
    <div class="container">
        <div class="row footer-bottom">
            <ul class="list-inline text-center">
                <li><?=Yii::$app->params['Copyright'];?></li>
            </ul>
        </div>
    </div>
</footer>


<input type="hidden" id="access_domain" value="<?=GlobalUrlService::buildBlogUrl("/");?>">
<?php $this->endBody() ?>

<?php echo \Yii::$app->view->renderFile("@blog/views/public/wechat.php");?>
<?php echo \Yii::$app->view->renderFile("@blog/views/public/stat.php");?>
</body>
</html>
<?php $this->endPage() ?>
