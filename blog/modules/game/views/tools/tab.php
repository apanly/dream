<?php
use \common\service\GlobalUrlService;
$items = [
	'gene_pwd' => [
		'title' => '密码生成',
		'url' => GlobalUrlService::buildGameUrl("/tools/index")
	],
	'strlen' => [
		'title' => '字符长度',
		'url' => GlobalUrlService::buildGameUrl("/tools/strlen")
	]
];
?>
<div class="am-container">
	<div class="am-tabs" id="doc-my-tabs">
		<ul class="am-tabs-nav am-nav am-nav-tabs ">
			<?php foreach( $items as $_key => $_item):?>
				<li <?php if($_key == $current):?> class="am-active" <?php endif;?>><a  href="<?=$_item['url'];?>"><?=$_item['title'];?></a></li>
			<?php endforeach;?>
		</ul>
	</div>
</div>
