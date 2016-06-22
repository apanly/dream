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
                            <a href="<?=GlobalUrlService::buildBlogUrl("/");?>">文章</a>
                        </li>
                        <li <?php if ($menu == "richmedia"): ?> class="nav-current" <?php endif; ?> >
                            <a href="<?=GlobalUrlService::buildBlogUrl("/richmedia/index");?>">富媒体</a>
                        </li>
                        <li <?php if ($menu == "library"): ?> class="nav-current" <?php endif; ?>>
                            <a href="<?=GlobalUrlService::buildBlogUrl("/library/index");?>">图书馆</a>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" >项目
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?=UrlService::buildUrl("/default/info",['id' => 21 ]);?>">二维码登录</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?=UrlService::buildUrl("/default/info",['id' => 132 ]);?>">微信墙</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?=UrlService::buildUrl("/default/info",['id' => 96 ]);?>">私人github</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?=UrlService::buildUrl("/default/info",['id' => 80 ]);?>">QQ音乐</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?=UrlService::buildUrl("/default/info",['id' => 91 ]);?>">metaweblog</a>
                                </li>
                            </ul>

                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" >小玩意
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li style="display: none;">
                                    <a href="<?=UrlService::buildGameUrl("/mv/index");?>">美女耍流氓</a>
                                </li>
                                <li class="divider" style="display: none;"></li>
                                <li>
                                    <a href="<?=UrlService::buildGameUrl("/tools/index");?>">密码生成器</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?=UrlService::buildGameUrl("/music/index");?>">点歌台</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?=GlobalUrlService::buildBlogUrl("/code/run");?>">Code Preview</a>
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
