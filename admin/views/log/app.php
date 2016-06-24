<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
use \admin\components\AdminUrlService;
StaticService::includeAppJsStatic("/js/log/app.js",\admin\assets\AppAsset::className());
?>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading ui-draggable-handle">
                    <h3 class="panel-title">错误日志</h3>
                </div>
                <div class="panel-body">
                    <div class="row stacked">
                        <form class="col-md-6" id="search_from">
                            <select name="type">
                                <option value="0">请选择应用</option>
                                <?php foreach( $log_type_mapping as $_type_id => $_type_title ):?>
                                    <option value="<?=$_type_id;?>" <?php if( $search_conditions['type'] == $_type_id ):?> selected <?php endif;?> ><?=$_type_title;?></option>
                                <?php endforeach;?>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <?php if($data):?>
                            <table class="table table-bordered table-hover no-footer" role="grid">
                                <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>app<br/>名称</th>
                                    <th>请求URI</th>
                                    <th>错误内容</th>
                                    <th>UA</th>
                                    <th>IP</th>
<!--                                    <th>Cookies</th>-->
                                    <th>时间</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($data as $_item):?>
                                    <tr id="trow_1">
                                        <td class="text-center"><?=$_item['idx'];?></td>
                                        <td><?=$_item['app_name'];?> </td>
                                        <td><?=$_item['request_uri'];?> </td>
                                        <td style="width: 200px;"><?=$_item['content'];?> </td>
                                        <td><?=$_item['ua'];?> </td>
                                        <td><?=$_item['ip'];?> </td>
<!--                                        <td>--><?//=$_item['cookies'];?><!-- </td>-->
                                        <td><?=$_item['created_time'];?> </td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        <?php endif;?>
                    </div>
                    <?php if($page_info['total_page']):?>
                    <div class="panel-footer">
                        <ul class="pagination pagination-sm pull-right">
                            <?php if($page_info['previous']):?>
                                <li>
                                    <a class="paginate_button previous" href="<?=AdminUrlService::buildUrl($page_url,array_merge( $search_conditions,['p'=>1] ) );?>">«</a>
                                </li>
                            <?php endif;?>
                            <?php for($pidx = $page_info['from'];$pidx <= $page_info['end'];$pidx ++ ):?>
                                <li class="<?php if($pidx == $page_info['current']):?> active <?php endif;?>">
                                    <a href="<?=AdminUrlService::buildUrl($page_url,array_merge( $search_conditions,['p'=>$pidx] ) );?>"><?=$pidx;?></a>
                                </li>
                            <?php endfor;?>
                            <?php if($page_info['next']):?>
                                <li>
                                    <a class="paginate_button next" href="<?=AdminUrlService::buildUrl($page_url,array_merge( $search_conditions,['p'=>$page_info['total_page']] ) );?>">»</a>
                                </li>
                            <?php endif;?>
                        </ul>
                    </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>