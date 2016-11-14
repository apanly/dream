<?php
use admin\components\StaticService;
use yii\helpers\Url;
use \common\service\GlobalUrlService;
StaticService::includeAppJsStatic(GlobalUrlService::buildStaticUrl("/highcharts/js/highcharts.js"),\admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic(GlobalUrlService::buildStaticUrl("/echarts/echarts.min.js"),\admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic(GlobalUrlService::buildStaticUrl("/echarts/china.js"),\admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/js/default/chart.js",\admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/js/default/index.js",\admin\assets\AdminAsset::className());
?>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
            <div class="box-1">
                <div class="row">
                    <div class="row-in">
                        <h2 class="columns-24 title-1">统计信息</h2>
                        <div class="columns-12">
                            <div class="widget-int num-count">博文总数：<?=$stat["posts"]["total"];?></div>
                            <div class="widget-int num-count">正常博文：<?=$stat["posts"]["total_valid"];?></div>
                        </div>
                        <div class="columns-12">
                            <div class="widget-int num-count">图书总数：<?=$stat["library"]["total"];?></div>
                            <div class="widget-int num-count">展示图书：<?=$stat["library"]["total_valid"];?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns-12">
            <div class="box-1">
                <div class="row">
                    <div class="row-in">
                        <div class="columns-24" id="client_browser_chart">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns-12">
            <div class="box-1">
                <div class="row">
                    <div class="row-in">
                        <div class="columns-24" id="source_chart">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns-12">
            <div class="box-1">
                <div class="row">
                    <div class="row-in">
                        <div class="columns-24" id="client_os_chart">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns-12">
            <div class="box-1">
                <div class="row">
                    <div class="row-in">
                        <div class="columns-24" id="client_device_chart">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns-24">
            <div class="box-1">
                <div class="row">
                    <div class="row-in">
                        <div class="columns-24" id="access_line" style="height: 270px;">
                            每日访问人数图,用highcharts画图
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns-24">
            <div class="box-1">
                <div class="row">
                    <div class="row-in">
                        <div class="columns-24 hide" id="access_map" style="min-height: 400px;">
                           访问量分布地图
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="hide" id="hidden_wrap">
    <input type="hidden" name="data_access" value='<?=json_encode($data_access);?>'>
    <input type="hidden" name="data_client_os" value='<?=json_encode($data_client_os);?>'>
    <input type="hidden" name="data_source" value='<?=json_encode($data_source);?>'>
    <input type="hidden" name="data_client_browser" value='<?=json_encode($data_client_browser);?>'>
    <input type="hidden" name="data_client_device" value='<?=json_encode($data_client_device);?>'>
</div>