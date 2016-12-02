<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
use \common\service\GlobalUrlService;

StaticService::includeAppCssStatic("components/jquery_tags_input/jquery.tagsinput.min.css",\admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/components/jquery_tags_input/jquery.tagsinput.min.js",\admin\assets\AdminAsset::className());

StaticService::includeAppJsStatic("/ueditor/ueditor.config.js",\admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/ueditor/ueditor.all.min.js",\admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/ueditor/lang/zh-cn/zh-cn.js",\admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/js/posts/set.js",\admin\assets\AdminAsset::className());
?>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/posts_tab.php", ['current' => 'set']); ?>
        </div>
    </div>
</div>
<div class="row" id="post_add_edit">
    <div class="row-in">
        <div class="columns-18">
            <div class="row">
                <div class="row-in">
                    <div class="columns-3 text-right">
                        <label class="label-name inline"><i class="mark">*</i>标题</label>
                    </div>
                    <div class="columns-21">
                        <div class="input-wrap">
                            <input type="text" class="input-1" name="title" value="<?=$info?$info['title']:'';?>"/>
                        </div>
                    </div>
                    <div class="columns-3 text-right">
                        <label class="label-name inline"><i class="mark">*</i>内容</label>
                    </div>
                    <div class="columns-21">
                        <div class="box-c1 bg-gray">
                            <textarea  id="editor" name="content" style="height: 300px;"><?=$info?$info['content']:'';?></textarea>
                        </div>
                    </div>
                    <div class="columns-3 text-right">
                        <label class="label-name inline"><i class="mark">*</i>标签</label>
                    </div>
                    <div class="columns-18">
                        <div class="input-wrap">
                            <input type="text" class="input-1" name="tags" value="<?=$info?$info['tags']:'';?>"/>
                        </div>
                    </div>
                    <div class="columns-3">
                        <button type="button" class="btn-tiny mg-b0 get_tags">获取tags</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns-6">
            <div class="row">
                <div class="row-in">
                    <div class="columns-8 text-right">
                        <label class="label-name inline"><i class="mark">*</i>类型</label>
                    </div>
                    <div class="columns-16">
                        <div class="select-wrap">
                            <select name="type" id="type" class="select-1">
								<?php foreach($posts_type as $_key => $_type):?>
                                    <option value="<?=$_key;?>" <?php if($info && $_key == $info['type']):?> selected <?php endif;?> ><?=$_type;?></option>
								<?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="columns-8 text-right">
                        <label class="label-name inline"><i class="mark">*</i>状态</label>
                    </div>
                    <div class="columns-16">
                        <div class="select-wrap">
                            <select name="status" id="status" class="select-1">
								<?php foreach( $status_desc as $_key => $_item):?>
                                    <option value="<?=$_key;?>"  <?php if($info && $_key == $info['status']):?> selected <?php endif;?> ><?=$_item["desc"];?></option>
								<?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="columns-8 text-right">
                        <label class="label-name inline"><i class="mark">*</i>原创</label>
                    </div>
                    <div class="columns-16">
                        <div class="select-wrap">
                            <select name="original" id="original" class="select-1">
								<?php foreach( $original_desc as $_key => $_item):?>
                                    <option value="<?=$_key;?>"  <?php if($info && $_key == $info['original']):?> selected <?php endif;?> ><?=$_item["desc"];?></option>
								<?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="columns-16 offset-8">
                        <input type="hidden" name="post_id" value="<?=$info?$info['id']:0;?>">
                        <input type="button" value="保存" class="btn-small save">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
