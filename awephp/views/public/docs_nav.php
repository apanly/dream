<?php
use \common\service\GlobalUrlService;
$menu = \common\service\CacheHelperService::getAweMenu();
?>
<div class="col-md-3 sidebar_wrap">
    <div class="well sidebar-nav">
        <?php if( $menu ):?>
            <?php foreach( $menu as $_item ):?>
                <ul class="nav nav-list">
                    <li class="nav-header">
                        <i class="icon-document-alt-stroke"></i>
                        <span><?=$_item['title'];?></span>
                    </li>
                    <?php if( $_item['sub_menu'] ):?>
                        <?php foreach(  $_item['sub_menu'] as $_sub_item ):?>
                    <li class="<?=$_sub_item['doc_id'];?>">
                        <!--class="active"-->

                            <a href="<?=GlobalUrlService::buildPhpUrl("/docs/info",[ 'id' => $_sub_item['doc_id'] ]);?>" ><?=$_sub_item['doc_title'];?><?php if( $_sub_item['status']  == -1 ):?> <span class="label label-info pull-right">编辑中</span> <?php endif;?></a>
                    </li>
                        <?php endforeach;?>
                    <?php endif;?>
                </ul>
            <?php endforeach;?>
        <?php endif;?>
    </div>
</div>