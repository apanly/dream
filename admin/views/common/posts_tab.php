<?php
use \admin\components\AdminUrlService;
$mapping = [
    "index" => [
        'title' => "文章列表",
        "url" => AdminUrlService::buildUrl("/posts/index"),
        "status" => 1
    ],
    "set" => [
        'title' => "写文章",
        "url" => AdminUrlService::buildUrl("/posts/set"),
        "status" => 1
    ],
	"md_menu" => [
		'title' => "教程菜单",
		"url" => AdminUrlService::buildUrl("/md/menu"),
		"status" => 1
	],
    "md_index" => [
		'title' => "教程列表",
		"url" => AdminUrlService::buildUrl("/md/index"),
		"status" => 1
	],
	"md_set" => [
		'title' => "写教程",
		"url" => AdminUrlService::buildUrl("/md/set"),
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
