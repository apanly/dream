<?php
use blog\components\StaticService;
use \blog\components\UrlService;
use \common\components\DataHelper;
StaticService::includeAppCssStatic("/css/wap/wechat_wall/sign.css",\blog\assets\MarketAsset::className());
StaticService::includeAppJsStatic("http://res.wx.qq.com/open/js/jweixin-1.0.0.js",\blog\assets\MarketAsset::className());
StaticService::includeAppJsStatic("/js/wap/wechat_wall/sign.js",\blog\assets\MarketAsset::className());
?>
<div class="user_info">
    <p><img src="<?=$user_info['avatar']?>" alt="" /></p>
    <p><?=DataHelper::encode($user_info['nickname'])?></p>
</div>
<div class="checkin_info">
    <p class="t1">恭喜您上墙成功！</p>
    <p class="t2">关闭本页面直接发送“<span style="font-weight: bold;color: #ff0000;font-size: large;">#消息内容</span>”即可参与互动哦！</p>
</div>
<a href="javascript:void(0)" id="close_checkin_window" class="button">关闭本页面</a>

<input type="hidden" name="can_award_user" value="">