<?php
use \blog\components\StaticService;
use \common\service\GlobalUrlService;

StaticService::includeAppCssStatic("/css/web/user/user.css",\blog\assets\AppAsset::className());

?>

<div class="aw-register-box aw-forget-box" style="margin-top: 100px;padding-bottom: 0px;">
    <div class="mod-head">
        <h1>找回密码</h1>
    </div>
    <div class="mod-body">
        <form class="aw-register-form" id="fpw_form" method="post" action="http://wenda.ghostchina.com/account/ajax/request_find_password/">
            <ul>
                <li class="alert alert-danger hide error_message">
                    <i class="icon icon-delete"></i><em></em>
                </li>
                <li>
                    <input class="aw-register-email form-control" type="text" placeholder="请输入邮箱" name="email">
                </li>
                <li class="aw-register-verify">
                    <img class="auth-img pull-right" id="captcha" src="<?=GlobalUrlService::buildBlogUrl("/user/img_captcha");?>" onclick="this.src='<?=GlobalUrlService::buildBlogUrl("/user/img_captcha");?>?'+Math.random();">
                    <input class="form-control" type="text" name="seccode_verify" placeholder="验证码">
                </li>
                <li class="clearfix">
                    <button class="btn btn-large btn-blue btn-block" onclick="AWS.ajax_post($('#fpw_form'), AWS.ajax_processer, 'error_message'); return false;">下一步</button>
                </li>
            </ul>
        </form>
    </div>
    <div class="mod-footer">
        <a href="<?=GlobalUrlService::buildUrl( "/user/login" );?>">返回登录</a>&nbsp;&nbsp;•&nbsp;&nbsp;
        <a href="<?=GlobalUrlService::buildUrl( "/" );?>">返回博客</a>&nbsp;&nbsp;•&nbsp;&nbsp;
        <a href="<?=GlobalUrlService::buildSuperMarketUrl( "/" );?>">返回杂货铺</a>
    </div>
</div>