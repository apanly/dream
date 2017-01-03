<?php
use \common\service\GlobalUrlService;
?>
<div class="col-md-3 sidebar_wrap">
    <div class="well sidebar-nav">
        <ul class="nav nav-list">
            <li class="nav-header">
                <i class="icon-document-alt-stroke"></i>
                <span>序言</span>
            </li>
            <li>
                <a href="<?=GlobalUrlService::buildNullUrl();?>" class="active">开个好头</a>
            </li>
        </ul>
        <ul class="nav nav-list">
            <li class="nav-header">
                <i class="icon-document-alt-stroke"></i>
                <span>简介</span>
            </li>
            <li><a href="<?=GlobalUrlService::buildNullUrl();?>">PHP是什么</a></li>
            <li><a href="<?=GlobalUrlService::buildNullUrl();?>">PHP可以做什么</a></li>
            <li><a href="<?=GlobalUrlService::buildNullUrl();?>">应具备的基础知识</a></li>
            <li><a href="<?=GlobalUrlService::buildNullUrl();?>">PHP文件是什么</a></li>
            <li><a href="<?=GlobalUrlService::buildNullUrl();?>">为什么使用 PHP？</a></li>
            <li><a href="<?=GlobalUrlService::buildNullUrl();?>">零基础也能学习</a></li>
        </ul>
    </div>
</div>