<?php
use \admin\components\StaticService;

StaticService::includeStaticCss("/jquery/fancy/jquery.fancybox.css",\admin\assets\AdminAsset::className());
StaticService::includeStaticJs("/jquery/fancy/jquery.fancybox.pack.js",\admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/js/richmedia/index.js", \admin\assets\AdminAsset::className());
?>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/richmedia_tab.php", ['current' => 'index']); ?>
        </div>
    </div>
</div>
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
                        <tr class="centered">
                            <td class="text-center"><?= $_item['idx']; ?></td>
                            <td>
                                <?php if ($_item['type'] == "image"): ?>
                                    <a href="<?= $_item['big_src_url']; ?>" class="image_gallary" rel="richmedia">
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
                                <a href="javascript:void(0);" class="edit_address" data="<?= $_item['id']; ?>" data-address="<?= $_item['address']; ?>">
                                    <i class="icon_club hastip" data-tip="编辑">&#xe610;</i>
                                </a>
                                <?php if ($_item['status']): ?>
                                    <a href="javascript:void(0);"  class="delete"  data="<?= $_item['id']; ?>">
                                        <i class="icon_club hastip" data-tip="隐藏">&#xe629;</i>
                                    </a>
                                <?php else: ?>
                                    <a href="javascript:void(0);" class="online" data="<?= $_item['id']; ?>">
                                        <i class="icon_club hastip" data-tip="展示">&#xe626;</i>
                                    </a>
                                <?php endif; ?>
                                <a href="javascript:void(0);" class="goaway" data="<?= $_item['id']; ?>">
                                    <i class="icon_club hastip" data-tip="删除">&#xe611;</i>
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

<div class="hide lay-small" id="pop_layer_wrap">
    <div class="row mg-t15">
        <div class="row-in">
            <div class="columns-6 text-right">
                <label class="label-name inline"><i class="mark">*</i>编辑地址：</label>
            </div>
            <div class="columns-17">
                <div class="input-wrap">
                    <input type="text" class="input-1"  name="address" value="">
                </div>
            </div>
            <div class="columns-18 offset-6">
                <input type="hidden" name="media-id" value="0">
                <button type="button" class="btn-small save">保存</button>
            </div>
        </div>
    </div>
</div>