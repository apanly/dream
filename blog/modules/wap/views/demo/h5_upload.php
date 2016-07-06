<?php
use blog\components\StaticService;
use \common\service\GlobalUrlService;
use \blog\components\UrlService;
StaticService::includeAppJsStatic("/js/wap/demo/h5_upload.js", \blog\assets\WapAsset::className());
?>
<div class="am-paragraph am-paragraph-default">
	<article class="am-article">
		<div class="am-article-hd">
			<h1 class="am-article-title">Demo标题</h1>
		</div>
		<hr data-am-widget="divider"  class="am-divider am-divider-default"/>
		<div class="am-article-bd  ">
			<div class="am-form-group am-form-file">
				<button type="button" class="am-btn am-btn-danger am-btn-sm">
					<i class="am-icon-cloud-upload"></i> 选择要上传的文件
				</button>
				<input id="upload" type="file" accept="image/*;" capture="camera" >
			</div>
		</div>

		<figure data-am-widget="figure" class="am am-figure am-figure-default am-no-layout">
			<img  class="img_wrap" style="display: none;">
		</figure>
	</article>
</div>

