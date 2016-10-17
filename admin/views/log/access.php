<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
StaticService::includeAppJsStatic("/js/bootstrap/bootstrap-datepicker.js",\admin\assets\AppAsset::className());
StaticService::includeAppJsStatic("/js/bootstrap/bootstrap-datepicker.zh-CN.min.js",\admin\assets\AppAsset::className());
StaticService::includeAppJsStatic("/js/log/access.js",\admin\assets\AppAsset::className());
?>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading ui-draggable-handle">
                    <h3 class="panel-title">访问日志</h3>
                </div>
                <div class="panel-body">
                    <div class="row form-horizontal" id="search_from">
                        <form>
                            <div class="col-md-5 col-lg-5">
                                <div class="form-group">
                                    <label class="col-md-2 control-label text-right">日期:</label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="text" name="date_from" class="form-control" value="<?=$search_conditions['date_from'];?>" data-date-format="yyyy-mm-dd">
                                        </div>
                                    </div>
                                    <label class="col-md-1 control-label text-center"> ~ </label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="text" name="date_to" class="form-control" value="<?=$search_conditions['date_to'];?>" data-date-format="yyyy-mm-dd">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <input type="hidden" name="source" value="<?=$search_conditions['source'];?>">
                                <input type="hidden" name="uuid" value="<?=$search_conditions['uuid'];?>">
                                <button type="submit" class="btn btn-info">搜索</button>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">

                            <table class="table table-bordered table-striped table-actions">
                                <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>目标URL</th>
                                    <th>来源</th>
                                    <th>UUID</th>
                                    <th>IP</th>
                                    <th>时间</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if($data):?>
                                    <?php foreach($data as $_item):?>
                                        <tr>
                                            <td class="text-center"><?=$_item['idx'];?></td>
                                            <td><?=$_item['target_url'];?> </td>
                                            <td><?=$_item['source'];?> </td>
                                            <td><?=$_item['uuid'];?></td>
                                            <td><?=$_item['ip'];?></td>
                                            <td><?=$_item['created_time'];?></td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php else:?>
                                    <tr><td colspan="6">暂无数据</td></tr>
                                <?php endif;?>
                                </tbody>
                            </table>
                        <?php if($data):?>
                            <?php echo \Yii::$app->view->renderFile("@admin/views/common/pagination.php",[
                                'page_info' => $page_info,
                                'url' => '/log/access',
                                'search_conditions' => $search_conditions,
                                'current_page_count' => count( $data )
                            ]);?>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>