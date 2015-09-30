<?php
use \admin\components\StaticService;
StaticService::includeAppJsStatic("/js/douban/mz.js",\admin\assets\AppAsset::className());
?>
<!-- START CONTENT FRAME -->
<div class="content-frame">

    <!-- START CONTENT FRAME TOP -->
    <div class="content-frame-top">
        <div class="page-title">
            <h2><span class="fa fa-image"></span> Gallery</h2>
        </div>
    </div>

    <!-- START CONTENT FRAME BODY -->
    <div class="content-frame-body content-frame-body-left" style="margin-right: 0px;">

        <div class="gallery" id="links">
            <?php if( $mz_list ):?>
                <?php foreach( $mz_list as $_mz_info ):?>
            <a class="gallery-item" href="javascript:void(0);" title="<?=$_mz_info['title'];?>" data-gallery>
                <div class="image" style="height: 347px;width: 240px;overflow:hidden;">
                    <img src="<?=$_mz_info['src_url'];?>" alt="<?=$_mz_info['title'];?>"/>
                    <ul class="gallery-item-controls">
                        <li><span class="gallery-item-remove"><i class="fa fa-times"></i></span></li>
                    </ul>
                </div>
                <div class="meta">
                    <strong><?=$_mz_info['title'];?></strong>
                </div>
            </a>
                  <?php endforeach;?>
            <?php endif;?>

        </div>
        <?php if($page_info['total_page']):?>
        <ul class="pagination pagination-sm pull-right push-down-20 push-up-20">
            <?php if($page_info['previous']):?>
            <li class="disabled"><a href="<?=$page_url;?>?p=1">«</a></li>
            <?php endif;?>
            <?php for($pidx = $page_info['from'];$pidx <= $page_info['end'];$pidx ++ ):?>
            <li <?php if($pidx == $page_info['current']):?> class="active" <?php endif;?>>
                <a href="<?=$page_url;?>?p=<?=$pidx;?>"><?=$pidx;?></a>
            </li>
            <?php endfor;?>
            <?php if($page_info['next']):?>
            <li><a href="<?=$page_url;?>?p=<?=$page_info['total_page'];?>">»</a></li>
            <?php endif;?>
        </ul>
        <?php endif;?>
    </div>
    <!-- END CONTENT FRAME BODY -->
</div>
<!-- END CONTENT FRAME -->