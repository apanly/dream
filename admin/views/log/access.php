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
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
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
                                    <tr id="trow_1">
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
                        <?php if($page_info['total_page']):?>
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                <?php if($page_info['previous']):?>
                                    <a class="paginate_button previous" href="<?=$page_url;?>?p=1">«</a>
                                <?php endif;?>
                                <span>
                            <?php for($pidx = $page_info['from'];$pidx <= $page_info['end'];$pidx ++ ):?>
                                <a class="paginate_button <?php if($pidx == $page_info['current']):?> current <?php endif;?>"  data-dt-idx="<?=$pidx;?>" href="<?=$page_url;?>?p=<?=$pidx;?>"><?=$pidx;?></a>
                            <?php endfor;?>
                        </span>
                                <?php if($page_info['next']):?>
                                    <a class="paginate_button next" href="<?=$page_url;?>?p=<?=$page_info['total_page'];?>">»</a>
                                <?php endif;?>
                            </div>
                        <?php endif;?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>