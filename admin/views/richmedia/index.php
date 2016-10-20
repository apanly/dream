<?php
use \admin\components\StaticService;

StaticService::includeAppCssStatic("/js/jquery/blueimp-gallery/css/blueimp-gallery.css", \admin\assets\AdminAsset::className());
StaticService::includeAppCssStatic("/js/jquery/blueimp-gallery/css/blueimp-gallery-indicator.css", \admin\assets\AdminAsset::className());
StaticService::includeAppCssStatic("/js/jquery/blueimp-gallery/css/blueimp-gallery-video.css", \admin\assets\AdminAsset::className());

StaticService::includeAppJsStatic("/js/jquery/blueimp-gallery/js/blueimp-helper.js", \admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/js/jquery/blueimp-gallery/js/blueimp-gallery.js", \admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/js/jquery/blueimp-gallery/js/blueimp-gallery-fullscreen.js", \admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/js/jquery/blueimp-gallery/js/blueimp-gallery-indicator.js", \admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/js/jquery/blueimp-gallery/js/blueimp-gallery-video.js", \admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/js/jquery/blueimp-gallery/js/blueimp-gallery-vimeo.js", \admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/js/jquery/blueimp-gallery/js/jquery.blueimp-gallery.js", \admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/js/richmedia/index.js", \admin\assets\AdminAsset::className());
?>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
            <table class="table-1">
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
                <?php if( $data ):?>
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
                <?php else:?>
                    <tr><td colspan="6">暂无</td></tr>
                <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="row-in">
        <div class="columns-24 text-right">
            <?php echo \Yii::$app->view->renderFile("@admin/views/common/pagination_v1.php",[
                'pages' => $page_info,
                'url' => '/richmedia/index',
                'search_conditions' => [],
                'current_page_count' => count($data)
            ]);?>
        </div>
    </div>
</div>


<div class="modal fade hide" role="dialog" aria-labelledby="gridSystemModalLabel">
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