<?php
use \common\service\GlobalUrlService;

$wx_urls = [
	"my" => GlobalUrlService::buildStaticUrl("/images/weixin/my.jpg"),
	"imguowei" => GlobalUrlService::buildStaticUrl("/images/weixin/imguowei_888.jpg"),
	"coderonin" => GlobalUrlService::buildStaticUrl("/images/weixin/coderonin.jpg"),
	"starzone" => GlobalUrlService::buildStaticUrl("/images/weixin/mystarzone.jpg"),
];
?>
<div class="modal fade" id="wechat_service_qrcode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h5 class="modal-title" id="myModalLabel">公众号二维码</h5>
			</div>
			<div class="modal-body">
				<img title="编程浪子走四方:CodeRonin" src="<?=$wx_urls['coderonin'];?>" style="width:270px;height:270px;">
			</div>
		</div>
	</div>
</div>