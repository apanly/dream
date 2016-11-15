<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
use \admin\components\AdminUrlService;
?>
<div class="row">
	<div class="row-in">
		<div class="columns-24">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/ops_tab.php", ['current' => 'index']); ?>
		</div>
	</div>
</div>