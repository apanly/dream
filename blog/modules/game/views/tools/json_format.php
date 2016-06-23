<?php
use blog\components\StaticService;
use \blog\components\UrlService;
StaticService::includeAppJsStatic("/js/game/tools/json_format/json_format.js", \blog\assets\GameAsset::className());
StaticService::includeAppJsStatic("/js/game/tools/index.js", \blog\assets\GameAsset::className());
?>
<?= Yii::$app->controller->renderPartial("/tools/tab.php",[ 'current' => 'json_format' ]); ?>
<div class="am-container" id="json_format" style="margin-top: 10px;">
	<form class="am-form">
		<div class="am-form-group">
			<textarea name="content" rows="15"></textarea>
		</div>
		<button type="button" class="am-btn am-btn-primary am-radius am-btn-block" style="margin-top: 5px;">格式化</button>
	</form>
</div>