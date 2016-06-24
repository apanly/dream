<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
?>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading ui-draggable-handle">
                    <h3 class="panel-title">访问日志</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <?php if($data):?>
                            <table class="table table-bordered table-striped table-actions">
                                <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>目标URL</th>
                                    <th>来源URL</th>
                                    <th>UA</th>
                                    <th>IP</th>
                                    <th>时间</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($data as $_item):?>
                                    <tr>
                                        <td class="text-center"><?=$_item['idx'];?></td>
                                        <td><?=$_item['target_url'];?> </td>
                                        <td><?=$_item['referer'];?> </td>
                                        <td><?=$_item['user_agent'];?> </td>
                                        <td><?=$_item['ip'];?> </td>
                                        <td><?=$_item['created_time'];?> </td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        <?php endif;?>
                        <?php echo \Yii::$app->view->renderFile("@admin/views/common/pagination.php",[
                            'page_info' => $page_info,
                            'url' => '/log/access',
                            'search_conditions' => $search_conditions,
                            'current_page_count' => count( $data )
                        ]);?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>