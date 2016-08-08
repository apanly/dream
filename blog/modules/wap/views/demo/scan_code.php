<?php
use \common\service\GlobalUrlService;
$barcode = '9787115281487';
$url = 'http://m.vincentguo.cn';
$email = 'mailto:apanly@163.com';
$vcard = 'BEGIN:VCARD
VERSION:3.0
FN:郭威
NICKNAME:编程浪子
TITLE:PHP研发工程师
TEL;TYPE=work:181****9661
TEL:181****9661
EMAIL:www.vincentguo.cn
END:VCARD';
$wifi = 'WIFI:T:WPA;S:ChuangJia-2F-B;P:123456789';
$sms = 'smsto:8613774355074:你好，二维码发短信';
$tel = "tel:13774355074";
?>
<div class="am-g">
	<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
		<section class="am-panel am-panel-default">
			<header class="am-panel-hd">
				<h3 class="am-panel-title">条形码</h3>
			</header>
			<div class="am-panel-bd">
				<div class="am-g">
					<div class="am-u-sm-12 am-u-md-12 am-u-lg-4">
						<div class="am-thumbnail">
							<img src="<?=GlobalUrlService::buildBlogUrl("/default/barcode",[ 'barcode' => $barcode ]);?>" alt=""/>
							<h3 class="am-thumbnail-caption am-text-center">Barcode 39</h3>
						</div>
					</div>
					<div class="am-u-sm-12 am-u-md-12 am-u-lg-4">
						<div class="am-thumbnail">
							<img src="<?=GlobalUrlService::buildBlogUrl("/default/barcode",[ 'barcode' => $barcode,'type' => 'EAN13' ]);?>" alt=""/>
							<h3 class="am-thumbnail-caption am-text-center">EAN13</h3>
						</div>
					</div>
					<div class="am-u-sm-12 am-u-md-12 am-u-lg-4">
						<div class="am-thumbnail">
							<img src="<?=GlobalUrlService::buildBlogUrl("/default/barcode",[ 'barcode' => $barcode,'type' => 'isbn' ]);?>" alt=""/>
							<h3 class="am-thumbnail-caption am-text-center">ISBN13</h3>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
		<section class="am-panel am-panel-default">
			<header class="am-panel-hd">
				<h3 class="am-panel-title">二维码</h3>
			</header>
			<div class="am-panel-bd">
				<div class="am-g">
					<div class="am-u-sm-12 am-u-md-12 am-u-lg-4">
						<div class="am-thumbnail">
							<img src="<?=GlobalUrlService::buildBlogUrl("/default/qrcode",[ 'qr_text' => '编程浪子的博客' ]);?>">
							<h3 class="am-thumbnail-caption am-text-center">文本</h3>
						</div>
					</div>
					<div class="am-u-sm-12 am-u-md-12 am-u-lg-4">
						<div class="am-thumbnail">
							<img src="<?=GlobalUrlService::buildBlogUrl("/default/qrcode",[ 'qr_text' => $url ]);?>" alt=""/>
							<h3 class="am-thumbnail-caption am-text-center">网址</h3>
						</div>
					</div>
					<div class="am-u-sm-12 am-u-md-12 am-u-lg-4">
						<div class="am-thumbnail">
							<img src="<?=GlobalUrlService::buildBlogUrl("/default/qrcode",[ 'qr_text' => $email ]);?>" alt=""/>
							<h3 class="am-thumbnail-caption am-text-center">Email</h3>
						</div>
					</div>
					<div class="am-u-sm-12 am-u-md-12 am-u-lg-4">
						<div class="am-thumbnail">
							<img src="<?=GlobalUrlService::buildBlogUrl("/default/qrcode",[ 'qr_text' => $wifi ]);?>" alt=""/>
							<h3 class="am-thumbnail-caption am-text-center">WIFI</h3>
						</div>
					</div>
					<div class="am-u-sm-12 am-u-md-12 am-u-lg-4">
						<div class="am-thumbnail">
							<img src="<?=GlobalUrlService::buildBlogUrl("/default/qrcode",[ 'qr_text' => $sms ]);?>" alt=""/>
							<h3 class="am-thumbnail-caption am-text-center">短信</h3>
						</div>
					</div>
					<div class="am-u-sm-12 am-u-md-12 am-u-lg-4">
						<div class="am-thumbnail">
							<img src="<?=GlobalUrlService::buildBlogUrl("/default/qrcode",[ 'qr_text' => $tel ]);?>" alt=""/>
							<h3 class="am-thumbnail-caption am-text-center">电话</h3>
						</div>
					</div>
					<div class="am-u-sm-12 am-u-md-12 am-u-lg-4 am-u-end" >
						<div class="am-thumbnail">
							<img src="<?=GlobalUrlService::buildBlogUrl("/default/qrcode",[ 'qr_text' => $vcard ]);?>" alt=""/>
							<h3 class="am-thumbnail-caption am-text-center">名片</h3>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

</div>