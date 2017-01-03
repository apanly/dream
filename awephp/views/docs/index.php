<?php
use awephp\components\StaticService;
StaticService::includeAppCssStatic( "/css/docs.css",\awephp\assets\AppAsset::className() );
StaticService::includeAppJsStatic( "/js/docs.js",\awephp\assets\AppAsset::className() );
?>
<div class="container-fluid docs">
    <div class="row-fluid">
		<?= Yii::$app->controller->renderPartial("/public/docs_nav"); ?>
        <div class="col-md-9 page">
            <div class="hero-unit">
                <?=$content;?>
            </div>
        </div>
    </div>
</div>