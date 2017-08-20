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
    <meta name="description" content="<?= DataHelper::encode($this->params['seo']['description']); ?>"/>
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
                        <span><?=DataHelper::encode( $this->params['current_member']['login_name'] );?>
                        <span>|</span>
                        <a href="<?=GlobalUrlService::buildUrl( "/user/logout" );?>">退出</a>
                    <?php else:?>
                    <a href="<?=GlobalUrlService::buildUrl( "/user/login" );?>">登录</a>
                    <span>|</span>
                    <a href="<?=GlobalUrlService::buildUrl( "/user/reg" );?>">注册</a>
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
                <li class="hide" >
                    <a href="<?=GlobalUrlService::buildSuperMarketUrl("/default/site");?>">建站模板</a>
                </li>
                <li class="mina">
                    <a href="<?=GlobalUrlService::buildSuperMarketUrl("/default/mina");?>">微信小程序</a>
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
                <div class="col-sm-12">
                    <div class="footer-qr-code">
                        <img src="<?=$code_ronin;?>" alt="编程浪子"
                             title="编程浪子"/>
                        <p>扫描关注 编程浪子走四方</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>