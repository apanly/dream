<?php
use \common\service\GlobalUrlService;
$wx_urls = [
    "my" => GlobalUrlService::buildStaticUrl("/images/weixin/my.jpg"),
    "imguowei" => GlobalUrlService::buildStaticUrl("/images/weixin/imguowei_888.jpg"),
    "starzone" => GlobalUrlService::buildStaticUrl("/images/weixin/mystarzone.jpg"),
];
?>
<main class="col-md-12 main-content">
    <article class="post page">

        <header class="post-head">
            <h1 class="post-title">郭大帅哥 PHP，Python 工程师</h1>
        </header>

        <section class="post-content">
            <blockquote>
                <p>
                    作为一个技术人员，当然希望建立一个自己的小小王国。此平台主要用户记录工作笔记和生活。
                </p>
            </blockquote>
            <ul>
                <li>姓名：郭威</li>
                <li>坐标：上海&bull;徐汇区&bull;田林</li>
                <li>工作经历：
                    <ul>
                        <li> 2010年10月 ~ 2011年06月 上海奥智 PHP开发</li>
                        <li> 2011年06月 ~ 2012年03月 上海新浪 PHP开发</li>
                        <li> 2012年03月 ~ 2015年04月 上海安居客 PHP开发，python DevOps</li>
                        <li> 2015年04月 ~ 至今 小型创业公司 PHP开发</li>
                    </ul>
                </li>
                <li>
                    项目:
                    <ul>
                        <li>自己写的php MVC框架：https://github.com/apanly/phpframe-simple</li>
                        <li>java版server：https://github.com/apanly/vserver</li>
                        <li>autohome:https://github.com/apanly/autohome</li>
                        <li>CMDB项目</li>
                        <li>Job调度管理平台</li>
                    </ul>
                </li>
            </ul>
            <hr>
            <ul>
                <li>Github：<a href="https://github.com/apanly">https://github.com/apanly</a></li>
                <li>Email：<a href="mailto:apanly@163.com">apanly@163.com</a></li>
                <li>
                    郭大帅哥的微信
                    <ul>
                        <li>
                            <img title="郭大帅哥的微信" src="<?=$wx_urls['my'];?>">
                        </li>
                    </ul>
                </li>
                <li>
                    郭大帅哥的故事（服务号）
                    <ul>
                        <li>
                            <img title="郭大帅哥的故事:imguowei_888" src="<?=$wx_urls['imguowei'];?>">
                        </li>
                    </ul>
                </li>
                <li>
                    狂神星域（订阅号）
                    <ul>
                        <li><img title="狂神星域:mystarzone" src="<?=$wx_urls['starzone'];?>"></li>
                    </ul>
                </li>
            </ul>
        </section>
    </article>
</main>