<?php
use \blog\components\StaticService;
use \common\service\GlobalUrlService;
use  \common\components\DataHelper;
?>
<style type="text/css">
	body{
		background-color: #f8f8f8;
		min-height: 800px;
	}
	.list-group-item.active, .list-group-item.active:focus, .list-group-item.active:hover{
		background-color:rgba(0,0,0,0.03);
		border-color:rgba(0,0,0,0.03);
	}
	.fa{
		margin: 0px 5px 0px 0px;
	}
</style>
<div class="col-sm-12 col-md-3 col-lg-3">
	<div class="row" style="margin-bottom: 5px;">
		<div class="col-sm-6 col-md-6 col-lg-6">
			<img  class="img-circle"  style="width: 100px; height: 100px;" src="<?=GlobalUrlService::buildPicStaticUrl("avatar","/{$this->params['current_member']['avatar']}",[ 'w' => 100,'h' => 100 ]);?>" >
		</div>
		<div class="col-sm-6 col-md-6 col-lg-6">
			<p><?=DataHelper::encode( $this->params['current_member']['login_name'] );?></p>
			<p><?=DataHelper::encode( $this->params['current_member']['email'] );?></p>
		</div>
	</div>
	<ul class="list-group">
		<li class="list-group-item <?php if($current == "index"):?> active <?php endif;?>">
			<a href="<?=GlobalUrlService::buildBlogUrl("/user/profile/index");?>"><i class="fa fa-user fa-lg"></i>个人资料</a>
		</li>
		<li class="list-group-item <?php if($current == "set_pwd"):?> active <?php endif;?>">
			<a href="<?=GlobalUrlService::buildBlogUrl("/user/profile/set-pwd");?>"><i class="fa fa-edit fa-lg"></i>修改密码</a>
		</li>
		<li class="list-group-item <?php if($current == "notice"):?> active <?php endif;?>">
			<a href="<?=GlobalUrlService::buildBlogUrl("/user/profile/notice");?>"><i class="fa fa-bell fa-lg"></i>订阅设置</a></li>
		<li class="list-group-item <?php if($current == "bind"):?> active <?php endif;?>">
			<a href="<?=GlobalUrlService::buildBlogUrl("/user/profile/bind");?>"><i class="fa fa-cog fa-lg"></i>绑定第三方账号</a></a></li>
	</ul>
</div>