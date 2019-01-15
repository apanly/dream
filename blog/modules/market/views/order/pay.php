<?php
use blog\components\StaticService;
use \common\service\GlobalUrlService;
StaticService::includeAppJsStatic("/js/market/order/pay.js", \blog\assets\AppAsset::className());
?>
<div class="row">
    <div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
        <h1 class="page-header">
			<?php if( $info['status'] == 1):?>
                订单详情
			<?php else:?>
                订单支付
			<?php endif;?>
            <a href="<?=GlobalUrlService::buildSuperMarketUrl("/order/my");?>" class="btn btn-link pull-right">查看订单列表</a>
        </h1>
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td>订单编号：<?=$info['order_sn'];?></td>
            </tr>
            <tr>
                <td>订单状态：<?=$info['status_desc'];?></td>
            </tr>
            <tr>
                <td>
                    <?php if( $info['status'] == 1):?>
                        支付时间：<?=$info['pay_time'];?>
                    <?php else:?>
                        创建时间：<?=$info['created_time'];?>
                    <?php endif;?>
                </td>
            </tr>
            <tr>
                <td>订单商品：
                    <?php foreach ( $info['items'] as $_item ):?>
                        <?=$_item['title'];?> X <?=$_item['quantity'];?>
                    <?php endforeach;?>
                </td>
            </tr>
            <tr>
                <td>订单金额：<?=$info['total_price'];?>元</td>
            </tr>
            <tr>
                <td>优惠金额：<?=$info['discount'];?>元</td>
            </tr>
            <tr>
                <td>应付金额：<?=$info['pay_price'];?>元</td>
            </tr>
            <?php if( $info['status'] == -8 ):?>
            <tr>
                <td>
                    <button type="button" class="btn btn-primary btn-block pay_soft" style="border-radius:6px;" data="<?=$info['order_sn'];?>">确认支付</button>
                </td>
            </tr>
            <?php endif;?>
            <tr>
                <td>
                    支付完成之后会自动发邮件（1分钟 ~ 5分钟一定会发送），请注意查收邮件。
                    <br/>如果无法收到邮件，请先查看垃圾箱。确认仍然没有，请点击 <a href="<?=GlobalUrlService::buildSuperMarketUrl("/default/about");?>">联系浪子</a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>