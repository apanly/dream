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
StaticService::includeAppJsStatic("/js/richmedia/index.js", \admin\assets\AppAsset::className());
?>
<div class="page-content-wrap">
    <div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading ui-draggable-handle">
                <h3 class="panel-title">多媒体列表</h3>
                <ul class="panel-controls">
                    <li><a href="javascript:void(0);" class="panel-refresh"><span class="fa fa-refresh"></span></a>
                    </li>
                </ul>
            </div>
            <div class="panel-body">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                    <?php if ($data): ?>
                    <table class="table table-bordered table-striped table-actions">
                    <thead>
                    <tr>
                        <th width="30">序号</th>
                        <th width="50">图片</th>
                        <th width="50">地址</th>
                        <th width="50">发布时间</th>
                        <th width="30">状态</th>
                        <th width="60">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $_item): ?>
                        <tr id="trow_1">
                            <td class="text-center"><?= $_item['idx']; ?></td>
                            <td>
                                <?php if ($_item['type'] == "image"): ?>
                                    <a href="<?= $_item['big_src_url']; ?>" data-gallery="">
                                        <img src="<?= $_item['small_src_url']; ?>"/>
                                    </a>
                                <?php else: ?>
                                    <video class="vbox" poster="<?= $_item['thumb_url']; ?>"
                                           controls="controls" preload="auto" height="100px">
                                        <source src="<?= $_item['src_url']; ?>" type="video/mp4">
                                    </video>


                                <?php endif; ?>
                            </td>
                            <td><?= $_item['address']; ?></td>
                            <td><?= $_item['created']; ?></td>
                            <td>
                                <span
                                    class="label label-<?= $_item['status_info']['class']; ?>"><?= $_item['status_info']['desc']; ?></span>
                            </td>
                            <td>
                                <a href="javascript:void(0);" class="btn btn-default btn-rounded btn-sm btn-address" data="<?= $_item['id']; ?>" data-address="<?= $_item['address']; ?>">
                                    <span class="fa fa-pencil"></span>
                                    编辑
                                </a>
                                <?php if ($_item['status']): ?>
                                    <a href="javascript:void(0);"
                                       class="btn btn-danger btn-rounded btn-sm delete"
                                       data="<?= $_item['id']; ?>">
                                        <span class="fa fa-times"></span>隐藏
                                    </a>
                                <?php else: ?>
                                    <a href="javascript:void(0);"
                                       class="btn btn-danger btn-rounded btn-sm online"
                                       data="<?= $_item['id']; ?>">
                                        <span class="fa fa-history"></span>展示
                                    </a>
                                <?php endif; ?>
                                <a href="javascript:void(0);"
                                   class="btn btn-danger btn-rounded btn-sm goaway"
                                   data="<?= $_item['id']; ?>">
                                    <span class="fa fa-times"></span>雪藏
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
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
                    <?php endif; ?>
                    <?php if ($page_info['total_page']): ?>
                    <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                            <?php if ($page_info['previous']): ?>
                                <a class="paginate_button previous" href="<?= $page_url; ?>?p=1">«</a>
                            <?php endif; ?>
                            <span>
                        <?php for ($pidx = $page_info['from']; $pidx <= $page_info['end']; $pidx++): ?>
                            <a class="paginate_button <?php if ($pidx == $page_info['current']): ?> current <?php endif; ?>"
                               data-dt-idx="<?= $pidx; ?>"
                               href="<?= $page_url; ?>?p=<?= $pidx; ?>"><?= $pidx; ?></a>
                        <?php endfor; ?>
                    </span>
                            <?php if ($page_info['next']): ?>
                                <a class="paginate_button next"
                                   href="<?= $page_url; ?>?p=<?= $page_info['total_page']; ?>">»</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
    </div>
</div>
<div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="gridSystemModalLabel">编辑地址</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <input type="text" name="address" class="form-control" value=""/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="media-id" value="0">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">保存</button>
            </div>
        </div>
    </div>
</div>