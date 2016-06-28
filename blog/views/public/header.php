<?php
use \blog\components\UrlService;
use \common\service\GlobalUrlService;
$menu = \blog\components\MenuService::blogMenu();
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
                <div class="collapse navbar-collapse" id="main-menu">
                    <ul class="menu">
                        <?php foreach( $menu as $_menu_key => $_menu_info ):?>
                            <?php if( isset($_menu_info['sub_menu']) ):?>
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" ><?=$_menu_info['title'];?>
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php foreach($_menu_info['sub_menu'] as $_submenu_key => $_submenu_info ):?>
                                            <li>
                                                <a href="<?=$_submenu_info['url'];?>"><?=$_submenu_info['title'];?></a>
                                            </li>
                                            <li class="divider"></li>
                                        <?php endforeach;;?>
                                    </ul>
                                </li>
                            <?php else:?>
                            <li <?php if ($menu == $_menu_key ): ?> class="nav-current" <?php endif; ?>>
                                <a href="<?=$_menu_info['url'];?>"><?=$_menu_info['title'];?></a>
                            </li>
                            <?php endif;?>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- end navigation -->
