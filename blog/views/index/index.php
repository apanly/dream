<?php
use \common\service\GlobalUrlService;
$wx_urls = [
	"my" => GlobalUrlService::buildStaticUrl("/images/weixin/my.jpg"),
	"coderonin" => GlobalUrlService::buildStaticUrl("/images/weixin/coderonin.jpg")
];
?>
<article><!--lbox begin-->
	<div class="lbox"><!--banbox begin-->
		<div class="banbox">
			<div class="banner">
				<div id="banner" class="fader">
                    <?php foreach ( $banner_list as $_banner ):?>
					<li class="slide">
                        <a href="<?=$_banner['view_url'];?>"><img src="<?=$_banner['image_url'];?>"></a>
                    </li>
                    <?php endforeach;?>
					<div class="fader_controls">
						<div class="page prev" data-target="prev"></div>
						<div class="page next" data-target="next"></div>
						<ul class="pager_list"></ul>
					</div>
				</div>
			</div>
		</div><!--banbox end--><!--headline begin-->
		<div class="clearblank"></div>
		<div class="zhuanti whitebg"><h2 class="htitle">演示系统</h2>
			<ul>
				<?php foreach($project_list as  $_item_info ):?>
				<li>
                    <i class="ztpic">
                        <a href="<?=$_item_info['url'];?>"><img src="<?=$_item_info['cover'];?>"></a>
                    </i>
                    <b><?=isset($_item_info['desc'])?$_item_info['desc']:'';?></b>
                    <span><?=isset($_item_info['desc'])?$_item_info['desc']:'';?></span>
                    <a href="<?=$_item_info['url'];?>" class="readmore">查看</a>
                </li>
				<?php endforeach;?>
			</ul>
		</div>
		<div class="whitebg bloglist">
            <h2 class="htitle"><span class="hnav"><a href="<?=GlobalUrlService::buildBlogUrl("/default/index");?>" >更多</a></span>最新博文</h2>
			<ul><!--多图模式 置顶设计-->
                <?php foreach ( $blog_list as $_blog_info ):?>
				<li>
                    <h3 class="blogtitle"><a href="<?=$_blog_info['view_url'];?>"><?=$_blog_info['title'];?></a></h3>
					<span class="blogpic imgscale">
                        <?php if($_blog_info['original']):?>
                        <i><a href="<?=$_blog_info['view_url'];?>">原创</a></i>
                        <?php endif;?>
                        <a href="<?=$_blog_info['view_url'];?>" title=""><img src="<?=$_blog_info['image_url'];?>" height="140px;"></a>
                    </span>
					<p class="blogtext"><?=$_blog_info['content'];?></p>
					<p class="bloginfo">
                        <span><?=$_blog_info['author']['nickname'];?></span>
                        <span><?=$_blog_info['date'];?></span>
                    </p>
                    <a href="<?=$_blog_info['view_url'];?>" class="viewmore">阅读更多</a></li>
                <?php endforeach;?>
			</ul>
		</div><!--bloglist end--></div>
	<div class="rbox">
		<div class="card"><h2><?=$author['nickname'];?>的名片</h2>
			<p>网名：<?=$author['nickname'];?></p>
			<p>职业：互联网后端研发</p>
			<p>现居：上海-浦东新区</p>
			<p>Email：<?=$author['email'];?></p>
			<ul class="linkmore">
				<li>
                    <a href="mailto:<?=$author['email'];?>" class="iconfont icon-youxiang" title="我的邮箱"></a>
                </li>
				<li id="weixin">
                    <a href="<?=GlobalUrlService::buildNullUrl();?>" class="iconfont icon-weixin" title="关注我的微信"></a>
                    <i><img src="<?=$wx_urls['my'];?>"></i>
                </li>
			</ul>
		</div>
        <div class="whitebg paihang">
            <h2 class="htitle">热门博文</h2>
            <ul>
				<?php foreach ( $hot_blog_list as $blog_info ):?>
                    <li>
                        <i></i><a href="<?=$blog_info['view_url'];?>" title="<?=$blog_info['title'];?>"><?=$blog_info['title'];?></a>
                    </li>
				<?php endforeach;?>
            </ul>
        </div>
		<div class="whitebg tongji"><h2 class="htitle">站点信息</h2>
			<ul>
				<li><b>建站时间</b>：2015-09-30</li>
				<li><b>网站程序</b>：Nginx + Yii2 + Mysql</li>
				<li><b>微信公众号</b>：扫描二维码，关注我们</li>
				<img src="<?=$wx_urls['coderonin'];?>" class="tongji_gzh"></ul>
				<img src="<?=$wx_urls['my'];?>" class="tongji_gzh">
            </ul>
		</div>
	</div>
</article>