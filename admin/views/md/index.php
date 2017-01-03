<?php
use common\service\GlobalUrlService;
use \admin\components\StaticService;
StaticService::includeStaticCss("/editormd/css/editormd.min.css",\admin\assets\AdminAsset::className());
StaticService::includeStaticJs("/editormd/editormd.min.js",\admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/js/md/index.js",\admin\assets\AdminAsset::className());
?>

<div class="row">
	<div class="row-in">
        <div class="columns-24" id="editormd">
            <textarea style="display:none;">### Hello Editor.md !</textarea>
        </div>
	</div>
</div>
<div class="hide" id="hide_wrap">
    <input type="hidden" name="lib_path" value="<?=GlobalUrlService::buildStaticUrl("/editormd/lib/");?>">
</div>