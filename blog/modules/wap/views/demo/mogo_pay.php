<?php
use blog\components\StaticService;
Yii::$app->getView()->registerJsFile( 'https://res.wx.qq.com/open/js/jweixin-1.0.0.js' , ['depends' =>  \blog\assets\WapAsset::className() ]);
StaticService::includeAppJsStatic("/js/wap/demo/mogo_pay.js", \blog\assets\WapAsset::className());
?>

<div class="am-paragraph am-paragraph-default">
	<article class="am-article">
		<div class="am-article-hd">
			<h1 class="am-article-title">支付</h1>
		</div>
		<hr data-am-widget="divider"  class="am-divider am-divider-default"/>
		<div class="am-article-bd  am-form">
			<div class="am-form-group">
				<input type="text" name="openid"  placeholder="请输入支付openid">
			</div>
			<p><button type="button" class="pay am-btn am-btn-primary am-btn-block">支付</button></p>
			<p><button type="button" data="o-glQw3tyODapIuCOwFu47G2Kgq8" class="pay am-btn am-btn-primary am-btn-block">郭威支付</button></p>
			<p><button type="button" data="o-glQw469XL9XSmwXaFRQ-25LoJk" class="pay am-btn am-btn-primary am-btn-block">冯银鹏支付</button></p>
		</div>

	</article>
</div>

