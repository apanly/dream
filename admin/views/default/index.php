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
        <div class="columns-24 hide">
            <div class="box-3">
                <div class="row">
                    <div class="row-in">
                        <table class="table-1">
                            <thead>
                                <tr class="centered">
                                    <th colspan="4">博文统计</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="2">
                                博文（发布/总数）：<?=$stat["posts"]["total_valid"];?>/<?=$stat["posts"]["total"];?>
                                </td>
                                <td colspan="2">
                                    图书（展示/总数）：<?=$stat["library"]["total_valid"];?>/<?=$stat["library"]["total"];?>
                                </td>
                            </tr>
                            <?php if( $env['sys'] ):?>
                            <tr>
                                <td colspan="4">
                                    <?php foreach( $env['sys'] as $_title => $_val ):?>
                                        <?=$_title?>：<?=$_val;?><br/>
                                    <?php endforeach;?>
                                </td>
                            </tr>
                            <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns-24">
            <div class="box-3">
                <div class="row">
                    <div class="row-in">
                        <table class="table-1 centered">
                            <thead>
                            <tr>
                                <th colspan="7">网站统计概况</th>
                            </tr>
                            <tr>
                                <th>日期</th>
                                <th>浏览次数(PV)</th>
                                <th>独立访客(UV)</th>
                                <th>IP</th>
                                <th>新独立访客</th>
                                <th>回访客户</th>
                                <th>人均浏览页数</th>
                            </tr>
                            </thead>
                            <tbody>
							<?php if( $stat['summary'] ):?>
								<?php foreach( $stat['summary'] as $_item ):?>
                                    <tr>
                                        <td><?=$_item['date'];?></td>
                                        <td><?=$_item['total_number'];?></td>
                                        <td><?=$_item['total_uv_number'];?></td>
                                        <td><?=$_item['total_ip_number'];?></td>
                                        <td><?=$_item['total_new_user_number'];?></td>
                                        <td><?=$_item['total_returned_user_number'];?></td>
                                        <td><?=$_item['avg_pv_per_uv'];?></td>
                                    </tr>

								<?php endforeach;?>
							<?php endif;?>
                            </tbody>
                        </table>
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
    </div>
</div>

<div class="hide" id="hidden_wrap">
    <input type="hidden" name="data_access" value='<?=json_encode($data_access);?>'>
    <input type="hidden" name="data_client_os" value='<?=json_encode($data_client_os);?>'>
    <input type="hidden" name="data_source" value='<?=json_encode($data_source);?>'>
    <input type="hidden" name="data_client_browser" value='<?=json_encode($data_client_browser);?>'>
    <input type="hidden" name="data_client_device" value='<?=json_encode($data_client_device);?>'>
</div>