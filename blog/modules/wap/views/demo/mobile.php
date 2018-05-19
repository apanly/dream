<?php
use blog\components\StaticService;
use \common\service\GlobalUrlService;
StaticService::includeAppJsStatic("/js/wap/demo/mobile.js", \blog\assets\WapAsset::className());
?>
<ol class="am-breadcrumb">
	<li><a href="<?=GlobalUrlService::buildWapUrl("/demo/index");?>">Demo列表</a></li>
	<li class="am-active">手机归属地查询</li>
</ol>
<div class="am-paragraph am-paragraph-default">
	<article class="am-article">
		<div class="am-article-hd">
			<h1 class="am-article-title">手机归属地查询</h1>
		</div>
        <hr data-am-widget="divider"  class="am-divider am-divider-default"/>
        <div class="am-u-sm-12 am-u-md-12  am-u-lg-12">
            <form method="get" id="search">
                <div class="am-input-group am-input-group-default">
                    <input type="text" name="mobile" class="am-form-field" placeholder="请输入手机号码~" value="">
                    <span class="am-input-group-btn">
                        <button class="am-btn am-btn-default btn-search" type="button">
                            <span class="am-icon-search"></span>
                        </button>
                    </span>
                </div>
            </form>
            <br/>
            <div class="am-panel am-panel-default search_result am-hide">
                <div class="am-panel-bd">这是一个基本的面板组件。</div>
            </div>
        </div>

	</article>
</div>

