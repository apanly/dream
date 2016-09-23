<?php
use \common\service\GlobalUrlService;
use \blog\components\UrlService;
?>
<div class="col-md-8 main-content">
	<article class="post">
		<table class="table table-bordered text-center">
			<thead>
			<tr>
				<td>赞助人</td>
				<td>赞助金额</td>
				<td width="200">赞助原因</td>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td>唐萪衷</td>
				<td>88.00</td>
				<td class="text-left">
					做档案录入需要拍照上传保存,参考博文：<a target="_blank" href="<?=UrlService::buildUrl('/default/info',['id'=>150]);?>">HTML5 拍照上传</a>
				</td>
			</tr>
			</tbody>
		</table>
	</article>
</div>
<div class="col-md-4 sidebar">
	<div class="widget">
		<h4 class="title">感谢您的支持</h4>
		<div class="content m_qrcode">
			<img title="扫一扫手机阅读" src="<?=GlobalUrlService::buildStaticUrl("/images/pay/pay_wechat.jpg");?>" style="max-width: 100%;" height="300">
			<img title="扫一扫手机阅读" src="<?=GlobalUrlService::buildStaticUrl("/images/pay/pay_alipay.jpg");?>" style="max-width: 100%;" height="300">
		</div>
	</div>
</div>