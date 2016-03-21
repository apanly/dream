<?php
use blog\components\StaticService;
use \blog\components\UrlService;
use \common\service\GlobalUrlService;
StaticService::includeAppJsStatic("/js/mate/default/index.js", \blog\assets\GameAsset::className());
?>
<div class="am-u-sm-12 am-u-md-12 am-u-lg-12 am-text-center">
    <h1>2016年同学会报名<br/>T773 纯真年华 - 青春</h1>
</div>
<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
    <form class="am-form am-form-horizontal" id="enrol">
        <div class="am-form-group">
            <label for="nickname" class="am-u-sm-2 am-form-label">姓名：</label>
            <div class="am-u-sm-10">
                <input type="text" id="nickname" name="nickname" placeholder="请输入你的真实姓名">
            </div>
        </div>
        <div class="am-form-group">
            <label for="mobile" class="am-u-sm-2 am-form-label">手机（选填）：</label>
            <div class="am-u-sm-10">
                <input type="text" id="mobile" name="mobile" placeholder="请输入你的手机号码（此项可不填写）">
            </div>
        </div>

        <div class="am-form-group">
            <label for=person_number" class="am-u-sm-2 am-form-label">人数：</label>
            <div class="am-u-sm-10">
                <select id="person_number">
                    <?php foreach( $person_number_mapping as $_person_key => $_person_title ):?>
                    <option value="<?=$_person_key;?>"> <?=$_person_title;?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>

        <div class="am-form-group">
            <div class="am-u-sm-10 am-u-sm-offset-2">
                <button type="button" class="am-btn am-btn-primary save">报名</button>
            </div>
        </div>
        <div class="am-form-group">
            <div class="am-u-sm-10 am-u-sm-offset-2">
            <ul class="am-list">
                <li style="color: #ff0000;">1.可重复报名,以最后报名信息的为准</li>
                <li>2.回校时间定于2016年5月1日，票请自己订购</li>
                <li>3.在湖北十堰母校安排统一由 谭伟 组织</li>
                <li>4.群二维码如下<br/><img src="<?=GlobalUrlService::buildStaticUrl("/images/mate/qun.jpg");?>" width="350"/></li>
            </ul>
            </div>
        </div>
    </form>
</div>