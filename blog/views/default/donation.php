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
				<td>赞助时间</td>
				<td>赞助方式</td>
				<td width="200">赞助原因</td>
			</tr>
			</thead>
			<tbody>
                <tr>
                    <td>匿名</td>
                    <td>1.00</td>
                    <td>2017-07-16</td>
                    <td>微信扫码</td>
                    <td class="text-left">任性未留言</td>
                </tr>
                <tr>
                    <td>匿名</td>
                    <td>1.55</td>
                    <td>2017-07-03</td>
                    <td>微信扫码</td>
                    <td class="text-left">留言：想听框架经验之谈</td>
                </tr>
                <tr>
                    <td>匿名</td>
                    <td>6.60</td>
                    <td>2017-06-10</td>
                    <td>微信扫码</td>
                    <td class="text-left">为知识付费，文章地址:<a href="https://mp.weixin.qq.com/s?__biz=MzU0MDAwNDY2OQ==&tempkey=CT2wbHbNFxMRUPXByDD1wBufhVth6bm2ZR3%2BHs%2FLVU9%2FUJsFrxamncjYClRjuYgdUu3HmBrjebIRtjfRmUjpaIt7yYE5qp2embYItLZrGtaGam8VI%2F56r0odSXLnEmwHX9V9ojLDtdn5%2FScVmJwfZA%3D%3D&chksm=7b3e995a4c49104c8ff441e5a2ad2443847f5ccf65a1cdd0ba05ffae1f73ed57ece8b02ab6ee#rd" target="_blank">大神，我有个问题，帮我看看</a></td>
                </tr>
                <tr>
                    <td>德鸿</td>
                    <td>66.00</td>
                    <td>2017-06-06</td>
                    <td>支付宝扫码</td>
                    <td class="text-left">为源码付费</td>
                </tr>
                <tr>
                    <td>咸鱼</td>
                    <td>8.88</td>
                    <td>2017-05-20</td>
                    <td>QQ红包</td>
                    <td class="text-left">为知识付费，文章地址:<a href="https://mp.weixin.qq.com/s?__biz=MzU0MDAwNDY2OQ==&mid=2247483651&idx=1&sn=9a2e947e4557b0513bd987c4395fd70d&chksm=fb3e9951cc4910473d6ffe35357e9b11648712746f3804aeaf2acc07e8c352028280113a3fb7#rd" target="_blank">谁的青春不迷茫</a></td>
                </tr>
                <tr>
                    <td>叫我大头</td>
                    <td>1.00</td>
                    <td>2017-05-10</td>
                    <td>支付宝</td>
                    <td class="text-left">任性没留言</td>
                </tr>
                <tr>
                    <td>匿名</td>
                    <td>5.66</td>
                    <td>2017-04-24</td>
                    <td>微信扫码</td>
                    <td class="text-left">任性没留言</td>
                </tr>
                <tr>
                    <td>唐萪衷</td>
                    <td>88.00</td>
                    <td>2016-11-09</td>
                    <td>微信红包</td>
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
			<img title="扫一扫微信赞助" src="<?=GlobalUrlService::buildStaticUrl("/images/pay/pay_wechat.jpg");?>" style="max-width: 100%;" height="300">
			<img title="扫一扫支付宝赞助" src="<?=GlobalUrlService::buildStaticUrl("/images/pay/pay_alipay.jpg");?>" style="max-width: 100%;" height="300">

            <img title="扫一扫支付宝赞助" src="<?=GlobalUrlService::buildStaticUrl("/images/pay/pay_qq.jpg");?>" style="max-width: 100%;" height="300">
		</div>
	</div>
</div>