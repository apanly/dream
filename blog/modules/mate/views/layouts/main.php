<?php
use blog\assets\MateAsset;
use blog\components\StaticService;
use blog\components\UrlService;
use  \common\components\DataHelper;

MateAsset::register($this);
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
    <link rel="shortcut icon" href="/images/icon.png">
    <?php $this->head() ?>
    <?php $this->beginBody() ?>
</head>
<body>
<div class="am-g">
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
            <li>
                <a href="<?= UrlService::buildMateUrl("/gallary/index"); ?>" class="am-btn-warning">
                    <span class="am-icon-home"></span>
                    <span class="am-navbar-label">相册</span>
                </a>
            </li>
            <li>
                <a href="<?= UrlService::buildMateUrl("/contact/index"); ?>" class="am-btn-warning">
                    <span class="am-icon-paper-plane"></span>
                    <span class="am-navbar-label">通讯录</span>
                </a>
            </li>
            <li>
                <a href="<?= UrlService::buildMateUrl("/contact/index"); ?>" class="am-btn-warning">
                    <span class="am-icon-paper-plane"></span>
                    <span class="am-navbar-label">我</span>
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
