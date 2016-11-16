<?php
use blog\components\StaticService;
use \blog\components\UrlService;
use common\service\GlobalUrlService;

//https://github.com/yesmeck/jquery-jsonview
StaticService::includeStaticCss("/jquery/json_viewer/jquery.jsonview.min.css", \blog\assets\GameAsset::className());
StaticService::includeStaticJs("/jquery/json_viewer/jquery.jsonview.min.js", \blog\assets\GameAsset::className());
StaticService::includeAppJsStatic("/js/game/tools/index.js", \blog\assets\GameAsset::className());

?>
<?= Yii::$app->controller->renderPartial("/tools/tab.php", ['current' => 'json_format']); ?>
<style type="text/css">
    .jsonview .null {
        color: red;
    }

    .jsonview .bool {
        color: #fde3a7;
    }

    .jsonview .num {
        color: #bf55ec;
    }

    .jsonview .string {
        color: #00b16a;
        white-space: pre-wrap;
    }

    textarea[name=content]{
        height:450px;
        padding:0 10px 10px 20px;
        border:solid 1px #ddd;
        border-radius:0;
        resize: none;
        outline:none;
    }

    #json-renderer{
        height:450px;
        border-top:solid 1px #ddd;
        border-right:solid 1px #ddd;
        border-bottom:solid 1px #ddd;
        border-radius:0;
        resize: none;
        overflow-y:scroll;
        outline:none;
        position:relative;
    }
</style>
<div class="am-container" id="json_format" style="margin-top: 10px;">
    <form class="am-form">
        <div class="am-g">
            <div class="am-u-sm-6 am-u-md-6 am-u-lg-6" style="padding-right: 0px;">
                <div class="am-form-group">
                    <textarea name="content" style="" placeholder="在此输入json字符串..."></textarea>
                </div>
            </div>
            <div id="json-renderer" class="am-u-sm-6 am-u-md-6 am-u-lg-6"></div>
        </div>
        <button type="button" class="am-btn am-btn-primary am-radius am-btn-block am-hide" style="margin-top: 5px;">
            格式化
        </button>
    </form>

</div>