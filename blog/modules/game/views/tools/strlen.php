<?php
use blog\components\StaticService;
use \blog\components\UrlService;
StaticService::includeAppJsStatic("/js/game/tools/index.js", \blog\assets\GameAsset::className());
?>
<?= Yii::$app->controller->renderPartial("/tools/tab.php",[ 'current' => 'strlen' ]); ?>

<div class="am-container" id="strlen" style="margin-top: 10px;">
    <form class="am-form">
        <div class="am-form-group">
            <textarea name="content" rows="10"></textarea>
        </div>
        <div class="am-form-group">
            <label class="strlen_tip">共计：--</label>
        </div>
        <button type="button" class="am-btn am-btn-primary am-radius am-btn-block am-hide">统计</button>
    </form>
</div>