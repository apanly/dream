<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
StaticService::includeAppJsStatic("/js/jquery/plugins/jquery.tagsinput.min.js",\admin\assets\AppAsset::className());
StaticService::includeAppJsStatic("/js/jquery/plugins/summernote.js",\admin\assets\AppAsset::className());
StaticService::includeAppJsStatic("/js/posts/add.js",\admin\assets\AppAsset::className());
?>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="post_add_edit">
                <div class="panel panel-default">
                    <div class="panel-heading ui-draggable-handle">
                        <h3 class="panel-title"><strong>写文章</strong></h3>
                        <ul class="panel-controls">
                            <li>
                                <a href="javascript:void(0);" >文章列表</a>
                            </li>
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
                                        <textarea class="summernote" name="content" style="display: none;"><?=$info?$info['content']:'';?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-1 col-xs-12 control-label">标签</label>
                                    <div class="col-md-11 col-xs-12">
                                        <input type="text" class="form-control" name="tags" value="<?=$info?$info['tags']:'';?>"/>
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