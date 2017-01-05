<?php
use common\service\GlobalUrlService;
use \admin\components\StaticService;
StaticService::includeStaticCss("/editormd/css/editormd.min.css",\admin\assets\AdminAsset::className());
StaticService::includeStaticJs("/editormd/editormd.min.js",\admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/js/md/set.js",\admin\assets\AdminAsset::className());
?>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/posts_tab.php", ['current' => 'md_set']); ?>
        </div>
    </div>
</div>

<div class="row" id="md_content_wrap">
	<div class="row-in">
        <div class="columns-24">
            <div class="columns-2 text-right">
                <label class="label-name inline"><i class="mark">*</i>标题</label>
            </div>
            <div class="columns-8">
                <div class="input-wrap">
                    <input type="text" class="input-1" name="title" value="<?=$info?$info['title']:'';?>"/>
                </div>
            </div>
            <div class="columns-2 text-right">
                <label class="label-name inline"><i class="mark">*</i>状态</label>
            </div>
            <div class="columns-8">
                <div class="select-wrap">
                    <select name="status" id="status" class="select-1">
						<?php foreach( $status_desc as $_key => $_item):?>
                            <option value="<?=$_key;?>"  <?php if($info && $_key == $info['status']):?> selected <?php endif;?> ><?=$_item["desc"];?></option>
						<?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="columns-4 text-right">
                <input type="hidden" name="docs_id" value="<?=$info?$info['id']:0;?>">
                <input type="button" value="保存" class="btn-small save">
            </div>
        </div>
        <div class="columns-24" id="editormd">
            <textarea style="display:none;"><?=$info?$info['content']:'';?></textarea>
        </div>
        <div class="columns-24">
            <input type="button" value="保存" class="btn-small save">
        </div>
	</div>
</div>
<div class="hide" id="hide_wrap">
    <input type="hidden" name="lib_path" value="<?=GlobalUrlService::buildStaticUrl("/editormd/lib/");?>">
</div>