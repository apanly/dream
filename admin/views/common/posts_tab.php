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
