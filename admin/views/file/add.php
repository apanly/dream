<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
StaticService::includeAppJsStatic("/js/file/add.js",\admin\assets\AppAsset::className());
?>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="file_set" enctype="multipart/form-data" action="<?=Url::toRoute("/upload/file");?>" method="post">
                <div class="panel panel-default">
                    <div class="panel-heading ui-draggable-handle">
                        <h3 class="panel-title"><strong>上传文件</strong></h3>
                        <div class="pull-right">
                            <h3 class="panel-title">
                                <a href="<?=Url::toRoute("/file/index");?>">文件列表</a>
                            </h3>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-1 col-xs-12 control-label">上传文件</label>
                                <div class="col-md-11 col-xs-12">
                                    <input type="file" class="form-control" name="rich_media"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-primary pull-right save">上传</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>