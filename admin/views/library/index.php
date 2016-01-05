<?php
use \admin\components\StaticService;
StaticService::includeAppJsStatic("/js/bootstrap/bootstrap-datepicker.js", \admin\assets\AppAsset::className());
StaticService::includeAppJsStatic("/js/bootstrap/bootstrap-datepicker.zh-CN.min.js", \admin\assets\AppAsset::className());

StaticService::includeAppJsStatic("/js/library/index.js",\admin\assets\AppAsset::className());
?>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading ui-draggable-handle">
                    <h3 class="panel-title">图书列表</h3>
                    <ul class="panel-controls">
                        <li><a href="javascript:void(0);" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                        <?php if($data):?>
                            <table class="table table-bordered table-striped table-actions">
                                <thead>
                                <tr>
                                    <th width="30">序号</th>
                                    <th width="100">标题</th>
                                    <th width="100">发布时间</th>
                                    <th width="100">状态</th>
                                    <th width="60">操作</th>
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
                                            <span class="label label-<?=$_item['read_status_info']['class'];?>"><?=$_item['read_status_info']['desc'];?></span>
                                        </td>
                                        <td>

                                            <?php if($_item['status']):?>
                                                <a href="<?=$_item['edit_url'];?>" class="btn btn-default btn-rounded btn-sm">
                                                    <span class="fa fa-pencil"></span>
                                                    详情
                                                </a>
                                                <a  href="javascript:void(0);" class="btn btn-danger btn-rounded btn-sm delete" data="<?=$_item['id'];?>">
                                                    <span class="fa fa-times"></span>下架
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-default btn-rounded btn-sm btn-book-read" data="<?= $_item['id']; ?>" data-read-status="<?= $_item['read_status']; ?>" data-start-time="<?= $_item['read_start_time']; ?>" data-end-time="<?= $_item['read_end_time']; ?>">
                                                    <span class="fa fa-pencil"></span>
                                                    编辑
                                                </a>
                                            <?php else:?>
                                                <a  href="javascript:void(0);" class="btn btn-danger btn-rounded btn-sm online" data="<?=$_item['id'];?>">
                                                    <span class="fa fa-history"></span>上架
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

<div class="modal" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="gridSystemModalLabel">编辑图书状态</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row form-group">
                        <div class="col-md-3 text-right">
                            <label class="control-label">读书状态:</label>
                        </div>
                        <div class="col-md-9">
                            <select class="form-control select" id="read_status">
                                <?php foreach($read_status as $_idx => $_item):?>
                                <option value="<?=$_idx;?>"><?=$_item["desc"];?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 text-right">
                            <label class="control-label">计划开始时间:</label>
                        </div>
                        <div class="col-md-9" style="z-index: 9000;">
                            <input type="text" class="form-control datepicker"  name="read_start_time" value="<?=date("Y-m-d");?>">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 text-right">
                            <label class="control-label">计划结束时间:</label>
                        </div>
                        <div class="col-md-9" style="z-index: 9000;">
                            <input type="text" class="form-control datepicker" name="read_end_time" value="<?=date("Y-m-d");?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="book_id" value="0">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">保存</button>
            </div>
        </div>
    </div>
</div>