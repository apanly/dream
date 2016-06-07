<?php
use admin\components\StaticService;
use yii\helpers\Url;
?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

<!-- START WIDGETS -->
<div class="row">
    <div class="col-md-6">

        <!-- START WIDGET MESSAGES -->
        <div class="widget widget-default widget-item-icon" >
            <div class="widget-item-left">
                <a href="<?=Url::toRoute("/posts/index");?>"><span class="fa fa-edit"></span></a>
            </div>
            <div class="widget-data">
                <div class="widget-int num-count">博文总数：<?=$stat["posts"]["total"];?></div>
                <div class="widget-int num-count">正常博文：<?=$stat["posts"]["total_valid"];?></div>
                <div class="widget-title">今天发表：<?=$stat["posts"]["today"];?></div>
            </div>
        </div>
        <!-- END WIDGET MESSAGES -->

    </div>
    <div class="col-md-6">

        <!-- START WIDGET REGISTRED -->
        <div class="widget widget-default widget-item-icon">
            <div class="widget-item-left">
                <a href="<?=Url::toRoute("/library/index");?>"><span class="fa fa-book"></span></a>
            </div>
            <div class="widget-data">
                <div class="widget-int num-count">图书总数：<?=$stat["library"]["total"];?></div>
                <div class="widget-int num-count">展示图书：<?=$stat["library"]["total_valid"];?></div>
            </div>
        </div>
        <!-- END WIDGET REGISTRED -->

    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading ui-draggable-handle">
                <div class="panel-title-box">
                    <h3>访问折线图</h3>
                </div>
            </div>
            <div class="panel-body padding-0">
                每日访问人数图,用highcharts画图
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading ui-draggable-handle">
                <div class="panel-title-box">
                    <h3>博文折线图</h3>
                </div>
            </div>
            <div class="panel-body padding-0">
                博文折线图,两根线，一个已发布的，一个待发布的
            </div>
        </div>
    </div>
</div>
<!-- END WIDGETS -->
</div>