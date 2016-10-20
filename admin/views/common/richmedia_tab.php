<?php
use \admin\components\AdminUrlService;
$mapping = [
	"index" => [
		'title' => "多媒体列表",
		"url" => AdminUrlService::buildUrl("/richmedia/index"),
		"status" => 1
	],
	"upload" => [
		'title' => "多媒体上传",
		"url" => AdminUrlService::buildUrl("/richmedia/upload"),
		"status" => 1
	],
];
?>

<ul class="tab_title style_1">
	<?php foreach( $mapping as $_key => $_item ):?>
		<?php
		if( isset($_item['status']) && !$_item['status'] ){
			continue;
		}
		?>
		<li <?php if($current == $_key ):?> class="current" <?php endif;?>>
			<a href="<?=$_item['url'];?>"><?=$_item["title"];?></a>
		</li>
	<?php endforeach;?>
</ul>
