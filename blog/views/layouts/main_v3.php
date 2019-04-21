<?php
use blog\assets\BBSV3Asset;
use \common\service\GlobalUrlService;
use \common\components\DataHelper;
BBSV3Asset::register($this);
$wx_urls = [
	"my" => GlobalUrlService::buildStaticUrl("/images/weixin/my.jpg"),
	"coderonin" => GlobalUrlService::buildStaticUrl("/images/weixin/coderonin.jpg")
];
$menu_list = \blog\components\BlogUtilService::blogMenu();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <title><?= DataHelper::encode($this->title) ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <meta name="description" content="<?= DataHelper::encode($this->params['seo']['description']); ?>"/>
    <meta name="keywords" content="<?= DataHelper::encode($this->params['seo']['keywords']); ?>">
    <link rel="shortcut icon" href="<?= GlobalUrlService::buildStaticUrl("//static/v3/images/icon.png"); ?>">
    <link rel="icon" href="<?= GlobalUrlService::buildStaticUrl("//static/v3/images/icon.png"); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Set render engine for 360 browser -->
    <?php $this->head() ?>
    <?php $this->beginBody() ?>
</head>
<body>
<!--top begin-->
<header id="header">
    <div class="navbox"><h2 id="mnavh"><span class="navicon"></span></h2>
        <div class="logo"><a href="<?=GlobalUrlService::buildNullUrl();?>"><?=Yii::$app->params['author']['nickname'];?></a></div>
        <nav>
            <ul id="starlist">
                <?php foreach( $menu_list as $_menu_key => $_menu_info ):?>
                <?php
                if( isset( $_menu_info['status'] ) && !$_menu_info['status'] ){
                    continue;
                }
                ?>
                <?php if( isset($_menu_info['sub_menu']) ):?>
                    <li class="menu"><a href="<?=GlobalUrlService::buildNullUrl();?>"><?=$_menu_info['title'];?></a>
                        <ul class="sub">
		                    <?php foreach($_menu_info['sub_menu'] as $_submenu_key => $_submenu_info ):?>
								<?php
								if( isset( $_submenu_info['status'] ) && !$_submenu_info['status'] ){
									continue;
								}
								?>
                            <li><a href="<?=$_submenu_info['url'];?>"><?=$_submenu_info['title'];?></a></li>
							<?php endforeach;;?>
                        </ul>
                        <span></span>
                    </li>
                <?php else:?>
                        <li><a href="<?=$_menu_info['url'];?>"><?=$_menu_info['title'];?></a></li>
                <?php endif;?>
				<?php endforeach;?>
            </ul>
        </nav>
    </div>
</header>
<div class="searchbox">
</div><!--top end-->
<?php echo $content ?>
<footer>
    <div class="box" style="text-align: center;">
        <div class="endnav">
            <p><?=\Yii::$app->params['Copyright'];?>
        </div>
    </div>
</footer>
<?php $this->endBody() ?>
<?php echo \Yii::$app->view->renderFile("@blog/views/public/stat.php");?>
</body>
</html>
<?php $this->endPage() ?>