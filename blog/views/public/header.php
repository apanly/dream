<?php
use \blog\components\UrlService;
use \common\service\GlobalUrlService;
?>
<header class="main-header" style="background-image: url(<?=GlobalUrlService::buildStaticUrl("/images/web/banner_bg.jpg");?>)">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <img src="<?=GlobalUrlService::buildStaticUrl("/images/web/xiuxing.png");?>" title="上善若水，人生就是修行"/>
            </div>
            <div class="col-sm-12">
                <img src="<?=GlobalUrlService::buildStaticUrl("/images/web/banner.png");?>" title="人类进化不易">
            </div>
        </div>
    </div>
</header>
<!-- end header -->

<!-- start navigation -->
<nav class="main-navigation">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="navbar-header">
                        <span class="nav-toggle-button collapsed" data-toggle="collapse" data-target="#main-menu">
                        <span class="sr-only">菜单</span>
                        <i class="fa fa-bars"></i>
                        </span>
                </div>
                <div class="collapse navbar-collapse" id="main-menu">
                    <ul class="menu">
                        <li <?php if ($menu == "blog"): ?> class="nav-current" <?php endif; ?>>
                            <a href="/">文章</a>
                        </li>
                        <li <?php if ($menu == "richmedia"): ?> class="nav-current" <?php endif; ?> >
                            <a href="/richmedia/index">富媒体</a>
                        </li>
                        <li <?php if ($menu == "library"): ?> class="nav-current" <?php endif; ?>>
                            <a href="/library/index">图书馆</a>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" >小玩意
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?=UrlService::buildGameUrl("/mv/index");?>">美女耍流氓</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?=UrlService::buildGameUrl("/tools/index");?>">密码生成器</a>
                                </li>
                            </ul>

                        </li>
                        <li <?php if ($menu == "donation"): ?> class="nav-current" <?php endif; ?>>
                            <a href="/default/donation">赞助</a>
                        </li>
                        <li <?php if ($menu == "about"): ?> class="nav-current" <?php endif; ?>>
                            <a href="/default/about">关于</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- end navigation -->
