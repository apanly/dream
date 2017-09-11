<?php
use \blog\components\StaticService;
use \common\service\GlobalUrlService;
?>
<?php echo \Yii::$app->view->renderFile("@blog/views/user/profile/side.php",[  'current' => 'bind' ]);?>
<div class="col-sm-12 col-md-9 col-lg-9">
	<div class="panel panel-default">
		<div class="panel-heading">绑定第三方账号</div>
		<div class="panel-body">
			<p>敬请期待，功能正在开发中</p>
			<p>将会集成 QQ、微博、Github登录</p>
		</div>
	</div>
</div>
