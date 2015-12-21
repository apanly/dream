<?php
use \common\service\GlobalUrlService;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title><?=$title;?></title>
    <meta name="description" content="<?=$title;?>"/>
    <meta name="keywords" content="<?=$title;?>">
    <meta name="HandheldFriendly" content="True"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="<?=GlobalUrlService::buildStaticUrl("/images/icon.png");?>">
    <link rel="icon" href="<?=GlobalUrlService::buildStaticUrl("/images/icon.png");?>">

    <link href="<?=GlobalUrlService::buildStaticUrl("/bootstrap/css/bootstrap.min.css");?>" rel="stylesheet">
    <link href="<?=GlobalUrlService::buildStaticUrl("/bootstrap/css/font-awesome.min.css");?>" rel="stylesheet">
    <link href="<?=GlobalUrlService::buildStaticUrl("/bootstrap/css/monokai_sublime.min.css");?>" rel="stylesheet">
    <script src="<?=GlobalUrlService::buildStaticUrl("/jquery/jquery.min.js");?>"></script
</head>
<body class="home-template">
<section class="content-wrap">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="text-center">
                            &nbsp;
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <img src="<?=GlobalUrlService::buildStaticUrl("/images/public/error.png");?>" class="img-responsive center-block" alt="<?=$msg;?>">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="text-center">
                            <label><?=$msg;?></label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="text-center">
                            <label id="tips">5秒后跳转</label>
                            <a id="redirect_url" href="<?=$reback_url;?>" class="btn btn-link">返回首页</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type='text/javascript'>
    var time_count = 5;
    var intervalid = setInterval(pload, 1000);
    function pload(){
        time_count--;
        if(time_count <= 0 ){
            clearInterval(intervalid);
            window.location.href = $("#redirect_url").attr("href");
            return;
        }
        $("#tips").html(time_count + "秒后跳转");
    }
</script>
</body>
</html>
