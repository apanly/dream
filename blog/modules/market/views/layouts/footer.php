<?php
use \common\service\GlobalUrlService;
$code_ronin =  GlobalUrlService::buildStaticUrl("/images/weixin/coderonin.jpg");
?>
<footer class="footer">
	<section class="footer-maps">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<div class="footer-qr-code">
						<img src="<?=$code_ronin;?>" alt="编程浪子"
							 title="编程浪子"/>
						<p>扫描关注 编程浪子走四方</p>
					</div>
					<div class="footer-maps-block">
						<a href="<?=GlobalUrlService::buildBlogUrl("/");?>"><h2>编程浪子</h2></a>
						<ul class="list-unstyled footer-maps-list">
							<li><a href="<?=GlobalUrlService::buildBlogUrl("/");?>">博客</a></li>
							<li><a href="<?=GlobalUrlService::buildDemoUrl("/");?>">演示系统</a></li>
							<li><a href="<?=GlobalUrlService::buildSuperMarketUrl("/");?>">源码空间</a></li>
							<li><a href="<?=GlobalUrlService::buildGameUrl("/");?>">小工具</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

</footer>
<div class="hidden_wrap" style="display: none;">
	<input type="hidden" id="access_domain" value="<?=GlobalUrlService::buildBlogUrl("/");?>">
	<input type="hidden" id="domain_static" value="<?=GlobalUrlService::buildStaticUrl("/");?>">
</div>
<?php echo \Yii::$app->view->renderFile("@blog/views/public/stat.php");?>