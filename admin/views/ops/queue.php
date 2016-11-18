<?php
use \admin\components\StaticService;
StaticService::includeAppJsStatic( \common\service\GlobalUrlService::buildStaticUrl("/prettify/prettify.js"),\admin\assets\AdminAsset::className() );
StaticService::includeAppCssStatic( \common\service\GlobalUrlService::buildStaticUrl("/prettify/prettify.sons.css"),\admin\assets\AdminAsset::className() );
StaticService::includeAppJsStatic("/js/ops/queue.js",\admin\assets\AdminAsset::className() );
?>
<style type="text/css">
    .color-orange .pun,.color-orange .pln {
        color: #ffa500 !important;
    }

    .color-danger .pun,.color-danger .pln {
        color: #db093f !important;
    }
    .prettyprint{
        padding: 0  0;
        border-radius:0;
        background-color:rgba(0,0,0,0.9);
        font-size: 13px;
    }
</style>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/ops_tab.php", ['current' => 'index']); ?>
        </div>
    </div>
</div>
<table class="table-1 full-width">
    <thead>
    <tr>
        <th>
            <div class="row">
                <div class="row-in">
                    <div class="columns-12">
                        <div class="text-left">
                            <h3>队列详情：每次上线之后建议关注 错误日志5分钟</h3>
                        </div>
                    </div>
                    <div class="columns-12">
                        <div class="text-right">
                            <h3>仓库：<?=$info['repo'];?> 状态：<?=$info['status_info']['title'];?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding: 0 0;">
                <pre class="prettyprint">
				<?php if( $fail_reason ):?>
                    <h2 class="color-danger">失败原因：<?php echo $fail_reason;?></h2>
				<?php endif;?>
				<?php foreach($cmds as $key=>$cmd):?>
                    <h2 class="color-orange">操作对象：<?php echo $key;?></h2>
                    <p><?php echo $cmd;?></p>
				<?php endforeach;?>
                </pre>
            </td>
        </tr>
    </tbody>
</table>