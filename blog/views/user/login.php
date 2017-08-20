<?php
use \blog\components\StaticService;
use \common\service\GlobalUrlService;

StaticService::includeAppCssStatic("/css/web/user/user.css",\blog\assets\AppAsset::className());
StaticService::includeAppJsStatic("/js/web/user/login.js", \blog\assets\AppAsset::className());
?>
<div id="wrapper">
    <div class="aw-login-box">
        <div class="mod-body clearfix">
            <div class="content pull-left">
                <h2 class="text-center" style="font-size: 200%;">登录</h2>
                <div id="login_form">
                    <ul>
                        <li>
                            <input type="text" id="aw-login-user-name" class="form-control" placeholder="请输入邮箱/用户名~~" name="login_name" value=""/>
                        </li>
                        <li>
                            <input type="password" id="aw-login-user-password" class="form-control" placeholder="请输入登录密码~~" name="login_pwd" value="" />

                        </li>
                        <li class="last">
                            <a href="<?=GlobalUrlService::buildNullUrl();?>"  id="login_submit" class="pull-right btn btn-large btn-primary do_login">登录</a>

                            <a href="<?=GlobalUrlService::buildUrl( "/user/forget" );?>">&nbsp;&nbsp;忘记密码？</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="side-bar pull-left">
                <h3>第三方账号登录</h3>
                <a href="<?=GlobalUrlService::buildBlogUrl("/user/oauth",[ "type" => "weibo" ]);?>" class="btn btn-block btn-weibo"><i class="icon icon-weibo"></i> 新浪微博登录</a>
                <a href="<?=GlobalUrlService::buildBlogUrl("/user/oauth",[ "type" => "qq" ]);?>" class="btn btn-block btn-qq"> <i class="icon icon-qq"></i> QQ登录</a>
            </div>
        </div>
        <div class="mod-footer">
            <span>还没有账号?</span>&nbsp;&nbsp;
            <a href="<?=GlobalUrlService::buildUrl( "/user/reg" );?>">立即注册</a>&nbsp;&nbsp;•&nbsp;&nbsp;
            <a href="<?=GlobalUrlService::buildUrl( "/" );?>">返回博客</a>&nbsp;&nbsp;•&nbsp;&nbsp;
            <a href="<?=GlobalUrlService::buildSuperMarketUrl( "/" );?>">返回杂货铺</a>
        </div>
    </div>
</div>
