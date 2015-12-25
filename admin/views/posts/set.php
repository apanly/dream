<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
use \common\service\GlobalUrlService;
StaticService::includeAppJsStatic("/js/jquery/plugins/jquery.tagsinput.min.js",\admin\assets\AppAsset::className());
StaticService::includeAppJsStatic("/ueditor/ueditor.config.js",\admin\assets\AppAsset::className());
StaticService::includeAppJsStatic("/ueditor/ueditor.all.min.js",\admin\assets\AppAsset::className());
//StaticService::includeAppJsStatic("/ueditor/ueditor.all.js",\admin\assets\AppAsset::className());
StaticService::includeAppJsStatic("/ueditor/lang/zh-cn/zh-cn.js",\admin\assets\AppAsset::className());
StaticService::includeAppJsStatic("/js/posts/set.js",\admin\assets\AppAsset::className());
?>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="post_add_edit">
                <div class="panel panel-default">
                    <div class="panel-heading ui-draggable-handle">
                        <h3 class="panel-title"><strong>写文章</strong></h3>

                        <ul class="panel-controls">
                            <?php if($info):?>
                                <a href="<?=$info["view_url"];?>" target="_blank">预览文章</a>
                            <?php endif;?>
                            <a href="<?=Url::toRoute("/posts/index");?>" >文章列表</a>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-md-1 col-xs-12 control-label">标题</label>
                                    <div class="col-md-11 col-xs-12">
                                        <input type="text" class="form-control" name="title" value="<?=$info?$info['title']:'';?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-1 col-xs-12 control-label">内容</label>
                                    <div class="col-md-11 col-xs-12">
                                        <textarea  id="editor" name="content" style="height: 300px;"><?=$info?$info['content']:'';?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-1 col-xs-12 control-label">标签</label>
                                    <div class="col-md-10 col-xs-12">
                                        <input type="text" class="form-control" name="tags" value="<?=$info?$info['tags']:'';?>"/>
                                    </div>
                                    <div class="col-md-1 col-xs-12">
                                        <a class="get_tags" href="javascript:void(0);">获取tags</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">

                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">类型</label>
                                    <div class="col-md-9 col-xs-12">
                                        <select name="type" id="type" class="form-control">
                                            <option value="0">请选择</option>
                                            <?php foreach($posts_type as $_key => $_type):?>
                                                <option value="<?=$_key;?>" <?php if($info && $_key == $info['type']):?> selected <?php endif;?> ><?=$_type;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">状态</label>
                                    <div class="col-md-9 col-xs-12">
                                        <select name="status" id="status" class="form-control">
                                            <?php foreach( $status_desc as $_key => $_item):?>
                                                <option value="<?=$_key;?>"  <?php if($info && $_key == $info['status']):?> selected <?php endif;?> ><?=$_item["desc"];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">原创</label>
                                    <div class="col-md-9 col-xs-12">
                                        <select name="original" id="original" class="form-control">
                                            <?php foreach( $original_desc as $_key => $_item):?>
                                                <option value="<?=$_key;?>"  <?php if($info && $_key == $info['original']):?> selected <?php endif;?> ><?=$_item["desc"];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input type="hidden" name="post_id" value="<?=$info?$info['id']:0;?>">
                        <button class="btn btn-primary pull-right save">保存</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
