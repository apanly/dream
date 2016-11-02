<?php
use yii\helpers\Html;
use admin\assets\AdminAsset;
use admin\components\AdminUrlService;
use \common\service\GlobalUrlService;

AdminAsset::register($this);
$seo_title = Yii::$app->params['seo']['title'];
$domain_blog = Yii::$app->params['domains']['blog'];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html class="no-js">
<head>
	<meta charset="utf-8">
	<link rel="icon" href="<?= GlobalUrlService::buildStaticUrl("/images/icon.png"); ?>" type="image/x-icon"/>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
	<?php $this->beginBody() ?>
</head>
<body>
<div class="page_wrap">
	<div class="box_wrap open">
		<div class="box_left_nav">
			<div class="logo centered">
                <div class="avatar-1">
                    <img src="<?= GlobalUrlService::buildStaticPic("/images/admin/my.jpg",[ 'w' => 80,'h' => 80 ]) ?>" alt="100*100">
                </div>
			</div>
			<h2 class="version">
                <a target="_blank" class="color-theme" href="<?=$domain_blog;?>"><?= $seo_title;?></a>
            </h2>
			<ul class="menu_list">
				<li class="menu_dashboard">
					<a href="<?=AdminUrlService::buildUrl("/default/index");?>">
						<i class="fa fa-dashboard fa-lg"></i><span>Dashboard</span>
					</a>
				</li>
				<li class="menu_posts">
					<a href="<?=AdminUrlService::buildUrl("/posts/index");?>">
						<i class="fa fa-pencil fa-lg"></i><span>文章</span>
					</a>
				</li>
				<li class="menu_account">
					<a href="<?=AdminUrlService::buildUrl("/account/index");?>">
						<i class="fa fa-user fa-lg"></i><span>账号</span>
					</a>
				</li>
				<li class="menu_richmedia">
					<a href="<?=AdminUrlService::buildUrl("/richmedia/index");?>">
						<i class="fa fa-camera fa-lg"></i><span>多媒体</span></a>
				</li>
				<li class="menu_library">
					<a href="<?=AdminUrlService::buildUrl("/library/index");?>">
						<i class="fa fa-book fa-lg"></i><span>图书</span>
					</a>
				</li>
				<li class="menu_files">
					<a href="<?=AdminUrlService::buildUrl("/file/index");?>">
						<i class="fa fa-cloud fa-lg"></i><span>文件</span>
					</a>
				</li>
				<li class="menu_stat">
					<a href="<?=AdminUrlService::buildUrl("/log/access");?>">
						<i class="fa fa-pie-chart fa-lg"></i><span>统计</span>
					</a>
				</li>
				<li class="menu_girl">
					<a href="<?=AdminUrlService::buildUrl("/douban/mz");?>">
						<i class="fa fa-file-photo-o  fa-lg"></i><span>豆瓣</span>
					</a>
				</li>
			</ul>
			<span class="menu_switch">
				<i class="icon_club">&#xe602;</i>
				<i class="icon_club arrow_left">&#xe60e;</i>
			</span>
		</div>
		<div class="box_main">
			<div class="box_top">
				<div class="row">
					<div class="row-in">
						<div class="columns-24">
							<div class="top_right hastips">
								<div class="search_box">
									<input type="text" placeholder="请输入博文关键字" class="search_input" id="top_search"/>
									<a href="javascript:void(0);" class="icon_club" id="top_search_icon">&#xe607;</a>
								</div>
								<a href="javascript:void(0);" class="icon_club setting" data-tip="设置">&#xe605;</a>
								<a href="javascript:void(0);" class="icon_club user has-panel" data-panel="user_menu">
									<img src="<?= GlobalUrlService::buildStaticPic("/images/admin/my.jpg",[ 'w' => 80,'h' => 80 ]) ?>" alt="80*80"/>
								</a>
								<ul class="user_menu hide">
									<li class="user_profile border">
										<p class="icon_club user">
                                            <img src="<?= GlobalUrlService::buildStaticPic("/images/admin/my.jpg",[ 'w' => 80,'h' => 80 ]) ?>" alt="80*80"/>
										</p>
										<p class="t1"><label class="t2"><?=$this->params['current_user']["mobile"];?></label></p>
										<p class="t3"><label class="t2"><?=$this->params['current_user']["nickname"];?></p>
<!--										<a href="javascript:void(0);" class="user_edit">编辑</a>-->
									</li>
									<li class="each border">
										<a href="javascript:void(0);"><i  class="icon_club">&#xe610;</i>修改密码</a>
									</li>
									<li class="each">
										<a href="<?=AdminUrlService::buildUrl("/auth/loginout");?>"><i class="icon_club">&#xe618;</i>退出</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="content_wrap">
				<?php echo $content ?>
			</div>
		</div>
	</div>
	<div class="footer_wrap">
		<div class="inner">
			Copyright&nbsp;&copy;&nbsp;<?=date("Y");?>&nbsp;&nbsp;
			<a href="<?=$domain_blog;?>" target="_blank"><?= $seo_title;?></a>
		</div>
	</div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
