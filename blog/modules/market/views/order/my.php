<?php
use blog\components\StaticService;
use \common\service\GlobalUrlService;
StaticService::includeAppCssStatic("/css/market/articles.css", \blog\assets\SuperMarketAsset::className());
?>
<div class="row border_row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <h1 class="page-header">
            订单列表
        </h1>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th width="15%">编号</th>
                <th width="6%">金额</th>
                <th>商品</th>
                <th width="6%">支付状态</th>
                <th width="10%">支付时间</th>
                <th width="10%">创建时间</th>
                <th width="10%">操作</th>
            </tr>
            </thead>
            <tbody>
			<?php if ($list): ?>
				<?php foreach ($list as $_item): ?>
                    <tr>
                        <td><?= $_item["order_sn"]; ?></td>
                        <td><?= $_item["pay_price"]; ?></td>
                        <td>
							<?php foreach ($_item['items'] as $_order_item): ?>
                                <a target="_blank"
                                   href="<?= GlobalUrlService::buildSuperMarketUrl("/default/info", ["id" => $_order_item['target_id']]); ?>"><?= $_order_item["title"]; ?>
                                    × <?= $_order_item["quantity"]; ?></a><br/>
							<?php endforeach; ?>
                        </td>
                        <td><?= $_item["status_desc"]; ?></td>
                        <td>
							<?php if ($_item['status'] == 1): ?>
								<?= $_item["pay_time"]; ?>
							<?php endif;; ?>
                        </td>
                        <td><?= $_item["created_time"]; ?></td>
                        <td>
							<?php if ($_item['status'] == 1): ?>
                                <a href="<?= GlobalUrlService::buildSuperMarketUrl("/order/pay", ["pay_sn" => $_item['order_sn']]); ?>">订单详情</a>
							<?php elseif ($_item['status'] == -8): ?>
                                <a href="<?= GlobalUrlService::buildSuperMarketUrl("/order/pay", ["pay_sn" => $_item['order_sn']]); ?>">支付订单</a>
							<?php endif;; ?>
                        </td>
                    </tr>
				<?php endforeach; ?>
			<?php else: ?>
                <tr>
                    <td colspan="7">您还没有下载过软件，可以去下载试试~~</td>
                </tr>
			<?php endif; ?>
            <tr>
            </tr>
            </tbody>
        </table>
		<?php echo \Yii::$app->view->renderFile("@blog/modules/market/views/common/pagination.php", [
			'pages'   => $pages,
			'url'  => '/order/my',
			'search_conditions' => [],
		]); ?>
    </div>

</div>