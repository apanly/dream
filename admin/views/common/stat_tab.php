<?php
use \admin\components\AdminUrlService;
$mapping = [
    "access" => [
        'title' => "访问日志",
        "url" => AdminUrlService::buildUrl("/log/access"),
        "status" => 1
    ],
    "uuid" => [
        'title' => "UUID统计",
        "url" => AdminUrlService::buildUrl("/log/uuid"),
        "status" => 1
    ],
    "source" => [
        'title' => "来源统计",
        "url" => AdminUrlService::buildUrl("/log/source"),
        "status" => 1
    ],
	"os" => [
		'title' => "操作系统统计",
		"url" => AdminUrlService::buildUrl("/log/os"),
		"status" => 1
	],
	"browser" => [
		'title' => "浏览器统计",
		"url" => AdminUrlService::buildUrl("/log/browser"),
		"status" => 1
	],
	"csp" => [
		'title' => "CSP统计",
		"url" => AdminUrlService::buildUrl("/log/csp"),
		"status" => 1
	],
    "error" => [
        'title' => "错误日志",
        "url" => AdminUrlService::buildUrl("/log/error"),
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
