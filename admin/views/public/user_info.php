<?php
use admin\components\StaticService;
use yii\helpers\Url;
?>
<li class="xn-logo">
    <a href="<?=Url::toRoute("/user/info");?>">郭大帅哥</a>
    <a href="javascript:void(0);" class="x-navigation-control"></a>
</li>
<li class="xn-profile">
    <a href="javascript:void(0);" class="profile-mini">
        <img src="<?= StaticService::buildStaticUrl("/images/users/my.jpg") ?>"/>
    </a>

    <div class="profile">
        <div class="profile-image">
            <img src="<?= StaticService::buildStaticUrl("/images/users/my.jpg") ?>" />
        </div>
        <div class="profile-data">
            <div class="profile-data-name">郭威</div>
            <div class="profile-data-title">PHP 开发工程师</div>
        </div>
        <div class="profile-controls">
            <a href="<?=Url::toRoute("/user/info");?>" class="profile-control-left"><span class="fa fa-info"></span></a>
            <a href="<?=Url::toRoute("/user/info");?>" class="profile-control-right"><span class="fa fa-envelope"></span></a>
        </div>
    </div>
</li>