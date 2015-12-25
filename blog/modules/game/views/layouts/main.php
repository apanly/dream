<?php
use blog\assets\GameAsset;
use blog\components\StaticService;
use blog\components\UrlService;
use \common\service\GlobalUrlService;
use  \common\components\DataHelper;

GameAsset::register($this);
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
<div class="am-g">
    <header data-am-widget="header" class="am-header am-header-default" style="display: none;">
        <div class="am-header-left am-header-nav">
            <a href="/">
                <i class="am-header-icon am-icon-home"></i>
            </a>
        </div>
        <h1 class="am-text-center" style="color: #ffffff;">
            <?= DataHelper::encode($this->params['subtitle']); ?>
        </h1>
    </header>
    <section>
        <?=$content;?>
    </section>
    <?php if( isset( $this->params['current_user'] ) ):?>
    <footer data-am-widget="footer"  class="am-footer am-footer-default">
        <div class="am-footer-miscs ">
            <p>欢迎您，<?= DataHelper::encode($this->params['current_user']['nickname']); ?></p>
            <p>由 郭大帅哥 提供技术支持</p>
        </div>
    </footer>
    <?php endif;?>

    <div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default">
        <ul class="am-navbar-nav am-cf am-avg-sm-4">
            <li id="menu_mv">
                <a href="<?= UrlService::buildGameUrl("/mv/index"); ?>" class="am-btn-default">
                    <span class="am-icon-home"></span>
                    <span class="am-navbar-label">美女</span>
                </a>
            </li>
            <li id="menu_tools">
                <a href="<?= UrlService::buildGameUrl("/tools/index"); ?>" class="am-btn-default">
                    <span class="am-icon-paper-plane"></span>
                    <span class="am-navbar-label">工具</span>
                </a>
            </li>
            <li  id="menu_music">
                <a href="<?= UrlService::buildGameUrl("/music/index"); ?>" class="am-btn-default">
                    <span class="am-icon-music"></span>
                    <span class="am-navbar-label">点歌</span>
                </a>
            </li>
        </ul>
    </div>
    <div data-am-widget="gotop" class="am-gotop am-gotop-fixed" style="display: none;">
        <a href="#top" title="回到顶部">
            <span class="am-gotop-title">回到顶部</span>
            <i class="am-gotop-icon am-icon-chevron-up"></i>
        </a>
    </div>
    <input type="hidden" id="access_domain" value="<?=\Yii::$app->params['domains']['blog'];?>">
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
