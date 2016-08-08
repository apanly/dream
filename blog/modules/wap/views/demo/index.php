<?php
use \common\service\GlobalUrlService;
?>
<style type="text/css">
	.doc-example {
		border: 1px solid #eee;
		border-top-right-radius: 0;
		border-top-left-radius: 0;
		padding: 0 15px 15px;
		margin: 5px 5px;
	}

	.doc-example:before {
		content: 'Demo';
		display: block;
		color: #bbb;
		text-transform: uppercase;
		margin: 0 -15px 15px;
		padding: 4px 10px;
		font-size: 12px;
	}
</style>
<div class="am-g">
	<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
		<div class="doc-example">
			<ul class="am-list am-list-border">
				<li>
					<a href="<?= GlobalUrlService::buildWapUrl("/wechat_wall/index"); ?>">
						<i class="am-icon-weixin am-icon-fw"></i> 微信墙
					</a>
				</li>
				<li>
					<a href="<?= GlobalUrlService::buildWapUrl("/demo/h5_upload"); ?>">
						<i class="am-icon-camera am-icon-fw"></i> H5拍照上传
					</a>
				</li>
				<li>
					<a href="<?= GlobalUrlService::buildWapUrl("/demo/scan_code"); ?>">
						<i  class="am-icon-qrcode am-icon-fw"></i> 生成条形码和二维码
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>