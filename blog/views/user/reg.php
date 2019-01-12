<?php
use \blog\components\StaticService;
use \common\service\GlobalUrlService;

StaticService::includeAppCssStatic("/css/oauth/user.css",\blog\assets\AppAsset::className());
StaticService::includeAppJsStatic("/js/web/user/reg.js", \blog\assets\AppAsset::className());

?>

<div class="aw-register-box">
    <div class="mod-head">
        <h1>注册新用户</h1>
    </div>
    <div class="mod-body">
        <div class="aw-register-form"  id="register_form">
            <ul>
                <li>
                    <input class="aw-register-name form-control" type="text" name="login_name" placeholder="请输入用户名~~"  value="">
                </li>
                <li>
                    <input class="aw-register-email form-control" type="text" placeholder="请输入邮箱~~" name="email"  value="">
                </li>
                <li>
                    <input class="aw-register-pwd form-control" type="password" name="login_pwd" placeholder="请设置一个密码~~" value="">
                </li>
                <li class="aw-register-verify">
                    <img class="pull-right" id="captcha" src="<?=GlobalUrlService::buildBlogUrl("/user/img_captcha");?>" onclick="this.src='<?=GlobalUrlService::buildBlogUrl("/user/img_captcha");?>?'+Math.random();">
                    <input type="text" class="form-control" name="captcha_code" placeholder="请输入右侧验证码~~" value="">
                </li>
                <li class="last">
                    <a href="<?=GlobalUrlService::buildBlogUrl("/user/login");?>" class="pull-left">已有账号?</a>
                    <button class="pull-right btn btn-large btn-primary do_reg" style="width: 120px;">注册</button>
                </li>
            </ul>
        </div>
    </div>
    <div class="mod-footer hide">
        <span>使用第三方账号直接登录</span>&nbsp;&nbsp;
        <a href="<?=GlobalUrlService::buildBlogUrl("/user/oauth",[ "type" => "weibo" ]);?>" class="btn btn-weibo"><i class="icon icon-weibo"></i> 新浪微博登录</a>
        <a href="<?=GlobalUrlService::buildBlogUrl("/user/oauth",[ "type" => "qq" ]);?>" class="btn btn-qq"> <i class="icon icon-qq"></i> QQ登录</a>
    </div>
</div>