<?php
use \common\service\GlobalUrlService;
$project_list =  \blog\components\BlogUtilService::getProjectList();
$default_cover = "http://cdn.pic1.54php.cn/20170610/16241f2cfbb6e8e37faa08d04767e00c.jpg?imageView/2/w/300";
?>
<div class="container projects">

    <div class="projects-header page-header">
        <h2>展示个人做的项目</h2>
        <h4>如无特殊说明，源码可无偿获取。本站也接受赞助，赞助地址：<a target="_blank" href="<?=GlobalUrlService::buildBlogUrl("/default/donation");?>">点击前往</a></h4>
    </div>
    <div class="row">
		<?php foreach($project_list as  $_item_info ):?>
        <div class="col-sm-6 col-md-4 col-lg-3 ">
            <div class="thumbnail" style="height: 336px;">
                <a href="<?=$_item_info['url'];?>" title="<?=$_item_info['title'];?>" target="_blank" >
                    <img  src="<?=isset($_item_info['cover'])?$_item_info['cover']:$default_cover;?>" width="300" height="150" style="height: 140px;">
                </a>
                <div class="caption" style="text-align: left;">
                    <h3>
                        <a href="<?=$_item_info['url'];?>" title="<?=$_item_info['title'];?>" target="_blank"><?=$_item_info['title'];?>
                            <?php if( isset( $_item_info['pay'] ) && $_item_info['pay'] ):?>
                            <span class="badge">付费课程</span>
                            <?php endif;?>
                        </a>
                    </h3>
                    <p>
						<?=isset($_item_info['desc'])?$_item_info['desc']:'';?>
                    </p>
                </div>
            </div>
        </div>
		<?php endforeach;?>
    </div>
</div><!-- /.container -->
