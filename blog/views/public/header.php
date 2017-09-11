<?php
use \blog\components\UrlService;
use \common\service\GlobalUrlService;
use  \common\components\DataHelper;
$menu_list = \blog\components\BlogUtilService::blogMenu();
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
                        <?php foreach( $menu_list as $_menu_key => $_menu_info ):?>
                            <?php
                                if( isset( $_menu_info['status'] ) && !$_menu_info['status'] ){
                                    continue;
                                }
                            ?>
                            <?php if( isset($_menu_info['sub_menu']) ):?>
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" ><?=$_menu_info['title'];?>
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php foreach($_menu_info['sub_menu'] as $_submenu_key => $_submenu_info ):?>
											<?php
											if( isset( $_submenu_info['status'] ) && !$_submenu_info['status'] ){
												continue;
											}
											?>
                                            <li>
                                                <a href="<?=$_submenu_info['url'];?>"><?=$_submenu_info['title'];?></a>
                                            </li>
                                            <li class="divider"></li>
                                        <?php endforeach;;?>
                                    </ul>
                                </li>
                            <?php else:?>
                            <li <?php if ($menu == $_menu_key ): ?> class="nav-current" <?php endif; ?>>
                                <a href="<?=$_menu_info['url'];?>" <?php if( isset( $_menu_info['tip'] ) ):?> title="<?=$_menu_info['tip'];?>" <?php endif;?> ><?=$_menu_info['title'];?></a>
                            </li>
                            <?php endif;?>

                        <?php endforeach;?>
						<?php if( isset( $this->params['current_member'] ) ):?>
                        <li>
                            <a style="color: #e67e22;" href="<?=GlobalUrlService::buildOauthUrl( "/user/profile/index" );?>">欢迎您，<?=DataHelper::encode( $this->params['current_member']['login_name'] );?></a>
                        </li>
						<?php endif;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- end navigation -->
