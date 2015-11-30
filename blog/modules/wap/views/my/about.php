<?php
use blog\components\StaticService;
use \common\service\GlobalUrlService;
use \blog\components\UrlService;

StaticService::includeAppJsStatic("/js/wap/my/index.js", \blog\assets\WapAsset::className());

$wx_urls = [
    "my" => GlobalUrlService::buildStaticUrl("/images/weixin/my.jpg"),
    "imguowei" => GlobalUrlService::buildStaticUrl("/images/weixin/imguowei_888.jpg"),
    "starzone" => GlobalUrlService::buildStaticUrl("/images/weixin/mystarzone.jpg"),
];
?>

<div data-am-widget="tabs" class="am-tabs am-tabs-d2" style="margin-top: 0px;">
    <ul class="am-tabs-nav am-cf">
        <li><a href="javascript:void(0);">工作履历</a></li>
        <li><a href="javascript:void(0);">捐赠</a></li>
    </ul>
</div>

<div data-am-widget="titlebar" class="am-titlebar am-titlebar-default">
    <h2 class="am-titlebar-title ">
        基本信息
    </h2>
</div>
<div data-am-widget="list_news" class="am-list-news am-list-news-default">
    <div class="am-list-news-bd">
        <ul class="am-list">
            <li class="am-g am-list-item-dated">
                <a href="javascript:void(0);" class="am-list-item-hd ">
                    姓名：郭威
                </a>
            </li>
            <li class="am-g am-list-item-dated">
                <a href="javascript:void(0);" class="am-list-item-hd ">
                    坐标：上海•徐汇区•田林
                </a>
            </li>
            <li class="am-g am-list-item-dated">
                <a href="javascript:void(0);" class="am-list-item-hd ">
                    老家：湖北
                </a>
            </li>
            <li class="am-g am-list-item-dated">
                <a href="javascript:void(0);" class="am-list-item-hd ">
                    学历：本科
                </a>
            </li>
            <li class="am-g am-list-item-dated">
                <a href="javascript:void(0);" class="am-list-item-hd ">
                    工作：4年+
                </a>
            </li>
            <li class="am-g am-list-item-dated">
                <a href="javascript:void(0);" class="am-list-item-hd ">
                    邮箱：apanly@163.com
                </a>
            </li>
        </ul>
    </div>

</div>
<div data-am-widget="titlebar" class="am-titlebar am-titlebar-default">
    <h2 class="am-titlebar-title ">
        职业技能
    </h2>
</div>
<div data-am-widget="list_news" class="am-list-news am-list-news-default">
    <div class="am-list-news-bd">
        <ul class="am-list">
            <li class="am-g am-list-item-dated">
                <a href="javascript:void(0);" class="am-list-item-hd ">
                    熟悉 LNMP（Linux/Nginx/MySql/PHP）环境开发
                </a>
            </li>
            <li class="am-g am-list-item-dated">
                <a href="javascript:void(0);" class="am-list-item-hd ">
                    熟悉自动化（vagrant,ansible,fabric）
                </a>
            </li>
            <li class="am-g am-list-item-dated">
                <a href="javascript:void(0);" class="am-list-item-hd ">
                    熟练使用 PHP/Python/Shell/JavaScript 编程
                </a>
            </li>
            <li class="am-g am-list-item-dated">
                <a href="javascript:void(0);" class="am-list-item-hd ">
                    熟悉 HTML+CSS+JS+NodeJS 等多种Web相关技术
                </a>
            </li>
            <li class="am-g am-list-item-dated">
                <a href="javascript:void(0);" class="am-list-item-hd ">
                    具有 MySQL数据库索引优化、查询优化和存储优化经验
                </a>
            </li>
            <li class="am-g am-list-item-dated">
                <a href="javascript:void(0);" class="am-list-item-hd ">
                    高并发程序开发经验,（日PV千万级）
                </a>
            </li>
        </ul>
    </div>

</div>


<div data-am-widget="titlebar" class="am-titlebar am-titlebar-default">
    <h2 class="am-titlebar-title ">
        工作经历
    </h2>
</div>

<div data-am-widget="list_news" class="am-list-news am-list-news-default">
    <div class="am-list-news-bd">
        <ul class="am-list">
            <li class="am-g am-list-item-dated">
                <a href="javascript:void(0);" class="am-list-item-hd ">
                    上海奥智 PHP开发
                </a>
                <span class="am-list-date">2010年10月 ~ 2011年06月</span>
            </li>
            <li class="am-g am-list-item-dated">
                <a href="javascript:void(0);" class="am-list-item-hd ">
                    上海新浪 PHP开发
                </a>
                <span class="am-list-date">2011年06月 ~ 2012年03月</span>
            </li>
            <li class="am-g am-list-item-dated">
                <a href="javascript:void(0);" class="am-list-item-hd ">
                    上海安居客 PHP开发
                </a>
                <span class="am-list-date">2012年03月 ~ 2015年04月</span>
            </li>
            <li class="am-g am-list-item-dated">
                <a href="javascript:void(0);" class="am-list-item-hd ">
                    小型创业公司 PHP开发
                </a>
                <span class="am-list-date">2015年04月 ~ 至今</span>
            </li>
        </ul>
    </div>

</div>
<div data-am-widget="titlebar" class="am-titlebar am-titlebar-default">
    <h2 class="am-titlebar-title" id="contact">
        联系方式
    </h2>
</div>
<div data-am-widget="list_news" class="am-list-news am-list-news-default">
    <div class="am-list-news-bd">
        <ul class="am-list">
            <li class="am-g am-list-item-dated">
                <a href="javascript:void(0);" class="am-list-item-hd ">
                    邮箱：apanly@163.com
                </a>
            </li>
            <li class="am-g am-list-item-dated">
                <a href="javascript:void(0);" class="am-list-item-hd ">
                    个人微信号：apanly
                </a>
            </li>
            <li class="am-g am-list-item-dated">
                <a href="javascript:void(0);" class="am-list-item-hd ">
                    微信服务号：imguowei_888
                </a>
            </li>
            <li class="am-g am-list-item-dated">
                <a href="javascript:void(0);" class="am-list-item-hd ">
                    赞助：请加个人微信，如果你觉得本站对你有用
                </a>
            </li>
        </ul>
    </div>
</div>

<div data-am-widget="titlebar" class="am-titlebar am-titlebar-default">
    <h2 class="am-titlebar-title ">
        微信二维码
    </h2>
</div>
<figure data-am-widget="figure" class="am am-figure am-figure-default">
    <img src="<?=$wx_urls["my"];?>" alt="个人微信号：apanly"/>

    <img src="<?=$wx_urls["imguowei"];?>" alt="微信服务号：imguowei_888"/>
</figure>

