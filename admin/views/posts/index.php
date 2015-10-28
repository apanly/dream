<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
StaticService::includeAppJsStatic("/js/posts/index.js",\admin\assets\AppAsset::className());
?>
<div class="page-content-wrap">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading ui-draggable-handle">
                <h3 class="panel-title">文章列表</h3>
                <ul class="panel-controls">
                    <li><a href="javascript:void(0);" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                    <li><a href="<?=Url::toRoute("/posts/set");?>"><span class="fa fa-edit"></span></a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                    <?php if($data):?>
                    <table class="table table-bordered table-striped table-actions">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>标题</th>
                            <th>发布时间</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($data as $_item):?>
                        <tr id="trow_1">
                            <td class="text-center"><?=$_item['idx'];?></td>
                            <td>
                                <a href="<?=$_item['view_url'];?>" target="_blank">
                                    <strong><?=$_item['title'];?></strong>
                                </a>
                            </td>
                            <td><?=$_item['created'];?></td>
                            <td>
                                <span class="label label-<?=$_item['status_info']['class'];?>"><?=$_item['status_info']['desc'];?></span>
                                <span class="label label-<?=$_item['original_info']['class'];?>"><?=$_item['original_info']['desc'];?></span>
                                <span class="label label-<?=$_item['hot_info']['class'];?>"><?=$_item['hot_info']['desc'];?></span>
                            </td>
                            <td>

                                <a href="<?=$_item['edit_url'];?>" class="btn btn-default btn-rounded btn-sm">
                                    <span class="fa fa-pencil"></span>
                                    编辑
                                </a>
                                <?php if($_item['status']):?>
                                <a  href="javascript:void(0);" class="btn btn-danger btn-rounded btn-sm delete" data="<?=$_item['id'];?>">
                                    <span class="fa fa-times"></span>隐藏
                                </a>
                                <?php else:?>
                                    <a  href="javascript:void(0);" class="btn btn-danger btn-rounded btn-sm online" data="<?=$_item['id'];?>">
                                        <span class="fa fa-history"></span>展示
                                    </a>
                                <?php endif;?>
                                <?php if($_item['hot']):?>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-rounded btn-sm down-hot" data="<?=$_item['id'];?>">
                                        <span class="fa fa-thumbs-down" ></span>下热门
                                    </a>
                                <?php else:?>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-rounded btn-sm go-hot" data="<?=$_item['id'];?>">
                                        <span class="fa fa-thumbs-up"></span>上热门
                                    </a>
                                <?php endif;?>

                            </td>
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