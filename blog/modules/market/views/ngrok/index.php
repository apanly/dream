<?php
use blog\components\StaticService;
use \common\service\GlobalUrlService;
StaticService::includeAppCssStatic("/css/market/articles.css", \blog\assets\SuperMarketAsset::className());
StaticService::includeAppJsStatic("/js/market/ngrok/index.js", \blog\assets\SuperMarketAsset::className());
?>
<div class="row border_row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <h1 class="page-header">
            Ngrok列表
        </h1>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th width="6%">编号</th>
                <th width="10%">域名前缀</th>
                <th>AuthToken</th>
                <th width="8%">开始时间</th>
                <th width="8%">结束时间</th>
                <th width="12%">创建时间</th>
                <th width="10%">操作</th>
            </tr>
            </thead>
            <tbody>
			<?php if ($list): ?>
				<?php foreach ($list as $_item): ?>
                    <tr>
                        <td><?= $_item["id"]; ?></td>
                        <td><?= $_item["prefix_domain"]; ?></td>
                        <td><?= $_item["auth_token"]; ?></td>
                        <td><?= $_item["start_time"]; ?></td>
                        <td><?= $_item["end_time"]; ?></td>
                        <td><?= $_item["created_time"]; ?></td>
                        <td>
							<?php if ( empty( $_item['prefix_domain'] ) && empty( $_item['auth_token'] ) ): ?>
                                <a class="do_ngrok" data="<?=$_item['id'];?>" href="<?= GlobalUrlService::buildNullUrl(); ?>">设置</a>
							<?php endif;; ?>
                        </td>
                    </tr>
				<?php endforeach; ?>
			<?php else: ?>
                <tr>
                    <td colspan="7">您还没有下购买过Ngrok~~</td>
                </tr>
			<?php endif; ?>
            <tr>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="ngrok_set_wrap" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">设置域名前缀</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal" role="form">
                    <div class="form-group" style="margin-bottom:0;">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="input-group">
                                <input type="text" class="form-control" name="prefix_domain"  placeholder="请输入域名前缀" value="">
                                <input type="hidden" name="id" value="0">
                                <div class="input-group-addon">.ngrok.54php.cn</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary save">保存</button>
            </div>
        </div>
    </div>
</div>
