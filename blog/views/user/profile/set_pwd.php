<?php
use \blog\components\StaticService;
use \common\service\GlobalUrlService;
use  \common\components\DataHelper;

StaticService::includeAppJsStatic("/js/web/user/profile/set_pwd.js", \blog\assets\AppAsset::className());

?>
<?php echo \Yii::$app->view->renderFile("@blog/views/user/profile/side.php",[  'current' => 'set_pwd' ]);?>

<div class="col-sm-12 col-md-9 col-lg-9">
	<div class="panel panel-default">
		<div class="panel-heading">修改密码</div>
		<div class="panel-body">
			<div class="wrap_set_pwd">
				<div class="form-group">
					<label>当前密码</label>
					<input type="password" name="pwd" class="form-control col-lg-4"  placeholder="请输入当前账号密码~~">
				</div>
				<div class="form-group">
					<label>新密码</label>
					<input type="password" name="pwd1" class="form-control col-lg-4"  placeholder="请输入新密码~">
				</div>
				<div class="form-group">
					<label>确认密码</label>
					<input type="password" name="pwd2" class="form-control col-lg-4"  placeholder="请输入确认密码~~">
				</div>
				<div class="form-group" >
					<button  class="btn btn-default save" style="margin-top: 10px;">确定修改</button>
				</div>
			</div>
		</div>
	</div>
</div>
