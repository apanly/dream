<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
use \admin\components\AdminUrlService;
StaticService::includeAppJsStatic("/js/file/upload.js",\admin\assets\AdminAsset::className());
?>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/file_tab.php", ['current' => 'upload']); ?>
        </div>
    </div>
</div>
<div class="row">
    <form  id="file_set" target="upload_file" enctype="multipart/form-data"  action="<?=AdminUrlService::buildUrl("/upload/file");?>" method="post">
        <div class="row-in">
            <div class="columns-5 text-right">
                <label class="label-name inline"><i class="mark">*</i>上传文件：</label>
            </div>
            <div class="columns-19">
                <div class="input-wrap">
                    <input type="file" class="input-1" name="rich_media"/>
                </div>
            </div>
            <div class="columns-19 offset-5">
                <button type="button" class="btn-small save">上传</button>
            </div>
        </div>
    </form>
</div>

<iframe name="upload_file" class="hide"></iframe>