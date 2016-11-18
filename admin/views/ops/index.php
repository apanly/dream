<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
use \admin\components\AdminUrlService;
StaticService::includeAppJsStatic("/js/ops/index.js",\admin\assets\AdminAsset::className());
?>
<div class="row">
	<div class="row-in">
		<div class="columns-24">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/ops_tab.php", ['current' => 'index']); ?>
		</div>
	</div>
</div>

<div class="row">
    <div class="row-in">
        <div class="title-3a">
            <div class="columns-16 right pull-right">
                <a href="javascript:void(0);">
                    <i class="fa fa-paper-plane fa-lg hastip release" data-tip="发布代码"></i>
                </a>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="row-in">
        <div class="columns-24">
            <table class="table-1">
                <thead>
                    <tr>
                        <th width="40">任务ID</th>
                        <th width="60">仓库</th>
                        <th width="100">描述</th>
                        <th width="150">操作时间</th>
                        <th width="150">状态</th>
                        <th width="80">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if( $data ):?>
                        <?php foreach( $data as $_item ):?>
                        <tr class="centered">
                            <td><?=$_item['id'];?></td>
                            <td><?=$_item['repo'];?></td>
                            <td><?=$_item['note'];?></td>
                            <td><?=$_item['created_time'];?></td>
                            <td>
                                <label style="border: 1px solid;border-radius: 10px;padding:0 15px; " class="<?=$_item['status']['class'];?>"><?=$_item['status']['title'];?></label>
                            </td>
                            <td>
                                <a href="<?=AdminUrlService::buildUrl("/ops/queue",[ 'id' => $_item['id'] ]);?>" class="color-theme">详情</a>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr>
                            <td colspan="6">暂无任务队列</td>
                        </tr>
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
				'url' => '/ops/index',
				'search_conditions' => $search_conditions,
				'current_page_count' => count($data)
			]);?>
        </div>
    </div>
</div>

<div class="hide lay-medium" id="pop_layer_wrap">

</div>