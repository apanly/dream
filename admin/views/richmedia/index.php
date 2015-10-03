<?php
use \admin\components\StaticService;
StaticService::includeAppCssStatic("/js/jquery/blueimp-gallery/css/blueimp-gallery.css", \admin\assets\AppAsset::className());
StaticService::includeAppCssStatic("/js/jquery/blueimp-gallery/css/blueimp-gallery-indicator.css", \admin\assets\AppAsset::className());
StaticService::includeAppCssStatic("/js/jquery/blueimp-gallery/css/blueimp-gallery-video.css", \admin\assets\AppAsset::className());

StaticService::includeAppJsStatic("/js/jquery/blueimp-gallery/js/blueimp-helper.js", \admin\assets\AppAsset::className());
StaticService::includeAppJsStatic("/js/jquery/blueimp-gallery/js/blueimp-gallery.js", \admin\assets\AppAsset::className());
StaticService::includeAppJsStatic("/js/jquery/blueimp-gallery/js/blueimp-gallery-fullscreen.js", \admin\assets\AppAsset::className());
StaticService::includeAppJsStatic("/js/jquery/blueimp-gallery/js/blueimp-gallery-indicator.js", \admin\assets\AppAsset::className());
StaticService::includeAppJsStatic("/js/jquery/blueimp-gallery/js/blueimp-gallery-video.js", \admin\assets\AppAsset::className());
StaticService::includeAppJsStatic("/js/jquery/blueimp-gallery/js/blueimp-gallery-vimeo.js", \admin\assets\AppAsset::className());
StaticService::includeAppJsStatic("/js/jquery/blueimp-gallery/js/jquery.blueimp-gallery.js", \admin\assets\AppAsset::className());
StaticService::includeAppJsStatic("/js/richmedia/index.js",\admin\assets\AppAsset::className());
?>
<div class="page-content-wrap">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading ui-draggable-handle">
                <h3 class="panel-title">多媒体列表</h3>
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
                            <th width="100">图片</th>
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
                                <a href="<?=$_item['src_url'];?>?format=/w/600" data-gallery="">
                                <img src="<?=$_item['src_url'];?>?format=/w/100"/>
                                </a>
                            </td>
                            <td><?=$_item['created'];?></td>
                            <td>
                                <span class="label label-<?=$_item['status_info']['class'];?>"><?=$_item['status_info']['desc'];?></span></td>
                            <td>
                                <?php if($_item['status']):?>
                                <a  href="javascript:void(0);" class="btn btn-danger btn-rounded btn-sm delete" data="<?=$_item['id'];?>">
                                    <span class="fa fa-times"></span>隐藏
                                </a>
                                <?php else:?>
                                    <a  href="javascript:void(0);" class="btn btn-danger btn-rounded btn-sm online" data="<?=$_item['id'];?>">
                                        <span class="fa fa-history"></span>展示
                                    </a>
                                <?php endif;?>
                                <a  href="javascript:void(0);" class="btn btn-danger btn-rounded btn-sm goaway" data="<?=$_item['id'];?>">
                                    <span class="fa fa-times"></span>雪藏
                                </a>
                            </td>
                        </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                        <!-- BLUEIMP GALLERY -->
                        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
                            <div class="slides"></div>
                            <h3 class="title"></h3>
                            <a class="prev">‹</a>
                            <a class="next">›</a>
                            <a class="close">×</a>
                            <a class="play-pause"></a>
                            <ol class="indicator"></ol>
                        </div>
                        <!-- END BLUEIMP GALLERY -->
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