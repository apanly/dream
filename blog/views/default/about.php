<?php
use \common\service\GlobalUrlService;
$wx_urls = [
    "my" => GlobalUrlService::buildStaticUrl("/images/weixin/my.jpg"),
    "coderonin" => GlobalUrlService::buildStaticUrl("/images/weixin/coderonin.jpg")
];
?>
<main class="col-md-12 main-content">
    <article class="post page">

        <header class="post-head">
            <h1 class="post-title">编程浪子 PHP，Python 工程师</h1>
        </header>

        <section class="post-content">
            <blockquote>
                <p>
                    作为一个技术人员，当然希望建立一个自己的小小平台。此平台主要用户记录工作笔记和生活。
                </p>
            </blockquote>
            <ul>
                <li>姓名：郭威</li>
                <li>坐标：上海&bull;徐汇区&bull;田林</li>
                <li>学历：本科</li>
                <li>工作：<?=(date("Y") - 2011);?>年+</li>
                <li>邮箱：apanly@163.com</li>
                <li>工作经历：
                    <ul>
                        <li> 2010年10月 ~ 2012年03月 上海新浪 PHP开发</li>
                        <li> 2012年03月 ~ 2015年04月 上海安居客 PHP开发，python DevOps，主管</li>
                        <li> 2015年04月 ~ 2017年03月 小型创业公司 PHP技术主管</li>
                        <li> 2017年03月 ~ 至今 蘑菇租房 业务架构主管</li>
                    </ul>
                </li>
                <li>职业技能：
                    <ul>
                        <li> 熟悉 LNMP（Linux/Nginx/MySql/PHP）环境开发</li>
                        <li> 熟悉自动化（vagrant,ansible,fabric）</li>
                        <li> 熟练使用 PHP/Python/Shell/JavaScript/Java 编程</li>
                        <li> 熟悉 HTML+CSS+JS+NodeJS 等多种Web相关技术</li>
                        <li> 具有 MySQL数据库索引优化、查询优化和存储优化经验</li>
                        <li> 高并发程序开发经验,（日PV千万级）</li>
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
                        <li>iPublish发布流程管理系统</li>
                    </ul>
                </li>
            </ul>
            <hr>
            <ul>
                <li>Github：<a href="https://github.com/apanly">https://github.com/apanly</a></li>
                <li>Email：<a href="mailto:apanly@163.com">apanly@163.com</a></li>
                <li>
                    编程浪子的微信
                    <ul>
                        <li>
                            <img title="编程浪子的微信" src="<?=$wx_urls['my'];?>">
                        </li>
                    </ul>
                </li>
                <li>
                    编程浪子走四方
                    <ul>
                        <li>
                            <img title="编程浪子走四方:CodeRonin" src="<?=$wx_urls['coderonin'];?>" width="250" height="250">
                        </li>
                    </ul>
                </li>
            </ul>
        </section>
    </article>
</main>
