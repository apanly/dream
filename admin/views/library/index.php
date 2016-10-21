<?php
use \admin\components\StaticService;
StaticService::includeAppJsStatic("/js/bootstrap/bootstrap-datepicker.js", \admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/js/bootstrap/bootstrap-datepicker.zh-CN.min.js", \admin\assets\AdminAsset::className());

StaticService::includeAppJsStatic("/js/library/index.js",\admin\assets\AdminAsset::className());
?>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/library_tab.php", ['current' => 'index']); ?>
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
                    <th width="100">标题</th>
                    <th width="100">发布时间</th>
                    <th width="100">状态</th>
                    <th width="60">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if( $data ):?>
                    <?php foreach ($data as $_item): ?>
                        <tr class="centered">
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
                                    <a href="<?=$_item['edit_url'];?>">
                                        <i class="icon_club hastip" data-tip="查看详情">&#xe616;</i>
                                    </a>
                                    <a  href="javascript:void(0);" class="delete" data="<?=$_item['id'];?>">
                                        <i class="icon_club hastip" data-tip="隐藏">&#xe611;</i>
                                    </a>
                                    <a href="javascript:void(0);" class="btn-book-read" data="<?= $_item['id']; ?>">
                                        <i class="icon_club">&#xe610;</i>
                                    </a>
                                <?php else:?>
                                    <a  href="javascript:void(0);" class="online" data="<?=$_item['id'];?>">
                                        <i class="icon_club hastip" data-tip="展示">&#xe626;</i>
                                    </a>
                                <?php endif;?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else:?>
                    <tr><td colspan="5">暂无</td></tr>
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
                'url' => '/library/index',
                'search_conditions' => [],
                'current_page_count' => count($data)
            ]);?>
        </div>
    </div>
</div>

<div class="hide lay-small" id="pop_layer_wrap">

</div>