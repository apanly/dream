<?php
use blog\assets\SuperMarketAsset;
use \common\service\GlobalUrlService;
use  \common\components\DataHelper;
$code_ronin =  GlobalUrlService::buildStaticUrl("/images/weixin/coderonin.jpg");

SuperMarketAsset::register($this);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="<?= GlobalUrlService::buildStaticUrl("/images/icon.png"); ?>">
    <link rel="icon" href="<?= GlobalUrlService::buildStaticUrl("/images/icon.png"); ?>">
    <title><?= DataHelper::encode($this->title) ?></title>
    <meta name="keywords" content="php网站源码,企业网站源码,手机网站源码,网站源码下载,VIP源码下载" />
    <meta name="description" content="网站源码频道提供大量的php源码,高质量免费网站源码,免费vip源码下载,PHP源码,JSP源码,HTML源码,企业网站源码,手机网站源码VIP源码下载，供大家免费下载，所有源码都经过详细测试后才分享 " />
    <?php $this->head() ?>
    <?php $this->beginBody() ?>
</head>
<body>
<section class="top-bar-element">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <a href="<?=GlobalUrlService::buildSuperMarketUrl("/");?>" class="top-bar-logo">
                    <img src="<?= GlobalUrlService::buildStaticUrl("/images/market/logo.png"); ?>">
                </a>
                <div class="top-bar-login">
                    <?php if( isset( $this->params['current_member'] ) ):?>
                        <a href="<?=GlobalUrlService::buildOauthUrl( "/user/profile/index" );?>"><?=DataHelper::encode( $this->params['current_member']['login_name'] );?></a>
                        <span>|</span>
                        <a href="<?=GlobalUrlService::buildOauthUrl( "/user/logout" );?>">退出</a>
                    <?php else:?>
                    <a href="<?=GlobalUrlService::buildOauthUrl( "/user/login" );?>">登录</a>
                    <span>|</span>
                    <a href="<?=GlobalUrlService::buildOauthUrl( "/user/reg" );?>">注册</a>
                    <?php endif;?>
                </div>
                <div class="top-bar-search hide">
                    <form method="GET" action="<?=GlobalUrlService::buildSuperMarketUrl("/search");?>" accept-charset="UTF-8" class="form-inline">
                        <div class="form-group">
                            <input class="form-control" placeholder="搜索" name="kw" type="text">
                        </div>
                        <button class="btn btn-success" type="submit"><i class="fa fa-search"></i></button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<nav class="navbar navbar-inverse nav-bar-element">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="nav navbar-nav">
                <li class="home"><a href="<?=GlobalUrlService::buildSuperMarketUrl("/");?>">首页</a></li>

                <li class="mina">
                    <a href="<?=GlobalUrlService::buildSuperMarketUrl("/default/mina");?>">微信小程序</a>
                </li>

                <li class="site" >
                    <a href="<?=GlobalUrlService::buildSuperMarketUrl("/default/site");?>">建站源码</a>
                </li>

                <li class="hide" >
                    <a href="<?=GlobalUrlService::buildSuperMarketUrl("/default/macapp");?>">Mac软件</a>
                </li>
                <li>
                    <a  href="<?=GlobalUrlService::buildBlogUrl("/");?>">博客</a>
                </li>
                <li>
                    <a  href="<?=GlobalUrlService::buildBlogUrl("/demo");?>">演示系统</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?= $content; ?>

<footer class="footer">
    <section class="footer-maps">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="footer-qr-code">
                        <img src="<?=$code_ronin;?>" alt="编程浪子"
                             title="编程浪子"/>
                        <p>扫描关注 编程浪子走四方</p>
                    </div>
                    <div class="footer-maps-block">
                        <a href="<?=GlobalUrlService::buildBlogUrl("/");?>"><h2>编程浪子</h2></a>
                        <ul class="list-unstyled footer-maps-list">
                            <li><a href="<?=GlobalUrlService::buildBlogUrl("/");?>">博客</a></li>
                            <li><a href="<?=GlobalUrlService::buildDemoUrl("/");?>">演示系统</a></li>
                            <li><a href="<?=GlobalUrlService::buildSuperMarketUrl("/");?>">源码空间</a></li>
                            <li><a href="<?=GlobalUrlService::buildGameUrl("/");?>">小工具</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

</footer>
<?php $this->endBody() ?>
<div class="hidden_wrap" style="display: none;">
    <input type="hidden" id="access_domain" value="<?=GlobalUrlService::buildBlogUrl("/");?>">
    <input type="hidden" id="domain_static" value="<?=GlobalUrlService::buildStaticUrl("/");?>">
</div>
<?php echo \Yii::$app->view->renderFile("@blog/views/public/stat.php");?>
</body>
</html>
<?php $this->endPage() ?>