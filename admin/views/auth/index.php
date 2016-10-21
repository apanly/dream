<?php
use admin\components\StaticService;
use \common\service\GlobalUrlService;
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>管理后台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?=GlobalUrlService::buildStaticUrl("/images/icon.png");?>">
    <link href="<?=StaticService::buildStaticUrl("/css/login/index.css");?>" rel='stylesheet' type='text/css'/>
    <style type="text/css">
        input:-webkit-autofill {
            -webkit-box-shadow : 0 0 0px 1000px none inset ;
        }
    </style>
</head>
<body>
<h2>&nbsp;</h2>
<div class="login-form">
    <div class="close"></div>
    <div class="head-info">
        <label class="lbl-1"> </label>
        <label class="lbl-2"> </label>
        <label class="lbl-3"> </label>
    </div>
    <div class="clear"></div>
    <div class="avtar">
        <img src="<?=StaticService::buildStaticUrl("/images/login/avatar.png");?>"/>
    </div>
    <input type="text" class="text" name="mobile" placeholder="请输入手机号码" autocomplete="off" >
    <div class="key"><input type="password" name="passwd" placeholder="请输入密码"></div>
    <div class="signin"><input type="submit" value="登录" class="login"></div>
</div>
<div class="copy-rights">
    <p><?=$copyright;?></p>
</div>
<script type="text/javascript" src="<?=StaticService::buildStaticUrl("/js/jquery/jquery-1.12.3.min.js");?>"></script>
<script type="text/javascript" src="<?=StaticService::buildStaticUrl("/js/login/index.js");?>"></script>
</body>
</html>