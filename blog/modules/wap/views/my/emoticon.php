<?php
use blog\components\StaticService;
use \common\service\GlobalUrlService;
?>
<style type="text/css">
	html,.am-g{
		background-color:#f8f8f8;
	}
	.am-navbar{
		display: none;
	}
	.am-with-fixed-navbar{
		padding-bottom: 0px;
	}
</style>
<figure data-am-widget="figure" class="am am-figure am-figure-default">
	<img src="<?=GlobalUrlService::buildStaticUrl("/app/cjdbq/icon.png");?>" style="width: 200px;height: 200px;" alt="超级逗表情"/>
</figure>
<div class="am-paragraph am-paragraph-default">
	<div class="am-text-center am-text-xl">
		超级逗表情<br/>
		V1.0<br/><br/><br/>
		产品：唐宝宝<br/>
		工程师：编程浪子
	</div>
</div>