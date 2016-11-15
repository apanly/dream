<?php
use \admin\components\AdminUrlService;
$mapping = [
    "access" => [
        'title' => "版本发布",
        "url" => AdminUrlService::buildUrl("/ops/index"),
        "status" => 1
    ],
    "error" => [
        'title' => "错误日志",
        "url" => AdminUrlService::buildUrl("/ops/error"),
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
