<?php
use \blog\components\StaticService;
StaticService::includeStaticJs("/plugin/highcharts/highcharts.js",\blog\assets\AppAsset::className() );
StaticService::includeAppJsStatic("/js/web/run/step.js",\blog\assets\AppAsset::className() );
?>
<style type="text/css">
    .sub_title {
        font-size: 18px;
    }
    .sub_title span{
        font-size: 14px;
    }
</style>
<div class="col-lg-12" style="margin-bottom: 10px;">
    <div class="btn-group">
        <a href="<?=$urls["daily"];?>" type="button" class="btn btn-default">日</a>
        <a href="<?=$urls["monthly"];?>" type="button" class="btn btn-default">月</a>
    </div>
</div>
<div class="col-lg-12" style="margin-bottom: 100px;">
    <div id="container" style="min-width:100%;height:400px"></div>
</div>
<input type="hidden" id="chart_data" value='<?=$data;?>'/>
<input type="hidden" id="chart_type" value="<?=$type;?>"/>
