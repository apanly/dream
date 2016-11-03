<?php
use admin\components\StaticService;
use \common\service\GlobalUrlService;
StaticService::includeAppJsStatic("/js/login/index.js",\admin\assets\AdminAsset::className());
?>
<div class="row">
    <div class="row-in login-form">
        <div class="columns-24 centered">
            <div class="avatar-1">
                <img src="<?= GlobalUrlService::buildStaticPic("/images/admin/my.jpg",[ 'w' => 80,'h' => 80 ]) ?>" alt="100*100">
            </div>
        </div>
        <div class="columns-24 mg-t10">
            <div class="columns-9">
                <label class="label-name inline">用户名：</label>
            </div>
            <div class="columns-6">
                <div class="input-wrap">
                    <input name="mobile" type="text" class="input-1" placeholder="请输入登录用户名" value="">
                </div>
            </div>
        </div>
        <div class="columns-24">
            <div class="columns-9">
                <label class="label-name inline">密码：</label>
            </div>
            <div class="columns-6">
                <div class="input-wrap">
                    <input name="passwd" type="password" class="input-1" placeholder="请输入登录密码" value="">
                </div>
            </div>
        </div>
        <div class="columns-6 offset-9 text-right">
            <input type="button" value="登录" class="btn-small login">
        </div>
    </div>
</div>