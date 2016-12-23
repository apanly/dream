<?php
use admin\components\StaticService;
use yii\helpers\Url;
use \common\service\GlobalUrlService;
StaticService::includeAppJsStatic(GlobalUrlService::buildStaticUrl("/highcharts/js/highcharts.js"),\admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic(GlobalUrlService::buildStaticUrl("/echarts/echarts.min.js"),\admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic(GlobalUrlService::buildStaticUrl("/echarts/china.js"),\admin\assets\AdminAsset::className());

StaticService::includeStaticJs( "/jquery/moment.min.js", \admin\assets\AdminAsset::className() );

StaticService::includeStaticCss("/jquery/daterangepicker/daterangepicker.min.css",\admin\assets\AdminAsset::className() );
StaticService::includeStaticJs( "/jquery/daterangepicker/jquery.daterangepicker.min.js", \admin\assets\AdminAsset::className() );


StaticService::includeAppJsStatic("/js/default/chart.js",\admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/js/default/index.js",\admin\assets\AdminAsset::className());
?>
<div class="row">
    <div class="row-in">
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
                                <th>最近更新时间</th>
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
                                        <td><?=$_item['updated_time'];?></td>
                                    </tr>

								<?php endforeach;?>
							<?php endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns-24">
            <div class="row chart_form_wrap">
                <div class="row-in">
                    <div class="columns-3">
                        <select class="select-1" name="custom_date">
							<?php foreach( $custom_date as $_text => $_item ):?>
                                <option date_from="<?=$_item["date_from"];?>" date_to="<?=$_item["date_to"];?>"><?=$_text;?></option>
							<?php endforeach;?>
                        </select>
                    </div>
                    <div class="columns-6">
                        <div class="input-wrap">
                            <input type="text" class="input-1 arrow" name="date_range_picker" value="">
                            <input type="hidden" class="input-1" name="date_from" value="2016-11-20">
                            <input type="hidden" class="input-1" name="date_to" value="2016-12-20">
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
    </div>
</div>

<div class="hide" id="hidden_wrap">
    <input type="hidden" name="data_access" value='<?=json_encode($data_access);?>'>
</div>