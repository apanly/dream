<?php
use \blog\components\StaticService;
use \common\service\GlobalUrlService;
?>
<?php echo \Yii::$app->view->renderFile("@blog/views/user/profile/side.php",[  'current' => 'notice' ]);?>
<div class="col-sm-12 col-md-9 col-lg-9">
	<div class="panel panel-default">
		<div class="panel-heading">订阅设置</div>
		<div class="panel-body">
			<p>敬请期待，功能正在开发中</p>
			<p>本功能目的是为了当系统有更新内容的时候，希望通过某几种方式推送给大家</p>
		</div>
	</div>
</div>
