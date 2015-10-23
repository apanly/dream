<?php
use \blog\components\UrlService;
?>
<div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default">
    <ul class="am-navbar-nav am-cf am-avg-sm-4">
        <li>
            <a href="<?=UrlService::buildWapUrl("/default/index");?>" class="am-btn-warning">
                <span class="am-icon-home"></span>
                <span class="am-navbar-label">文章</span>
            </a>
        </li>
        <li>
            <a href="<?=UrlService::buildWapUrl("/library/index");?>" class="am-btn-warning">
                <span class="am-icon-book"></span>
                <span class="am-navbar-label">图书馆</span>
            </a>
        </li>
        <li>
            <a href="<?=UrlService::buildWapUrl("/richmedia/index");?>" class="am-btn-warning">
                <span class="am-icon-picture-o"></span>
                <span class="am-navbar-label">富媒体</span>
            </a>
        </li>
        <li >
            <a href="javascript:void(0);" class="am-btn-warning">
                <span class="am-icon-user"></span>
                <span class="am-navbar-label">关于</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" class="am-btn-warning" data-am-modal="{target: '#wechat'}">
                <span class="am-icon-weixin"></span>
                <span class="am-navbar-label">联系我</span>
            </a>
        </li>
    </ul>
</div>


<div data-am-widget="gotop" class="am-gotop am-gotop-fixed" style="display: none;" >
    <a href="#top" title="回到顶部">
        <span class="am-gotop-title">回到顶部</span>
        <i class="am-gotop-icon am-icon-chevron-up"></i>
    </a>
</div>