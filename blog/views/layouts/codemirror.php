<?php
use yii\helpers\Html;
use blog\assets\CodeMirrorAsset;
use \common\service\GlobalUrlService;
use \common\components\DataHelper;

CodeMirrorAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title><?= DataHelper::encode($this->title) ?></title>
    <meta name="description" content="<?= DataHelper::encode($this->params['seo']['description']); ?>"/>
    <meta name="keywords" content="<?= DataHelper::encode($this->params['seo']['keywords']); ?>">
    <meta name="HandheldFriendly" content="True"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="<?=GlobalUrlService::buildStaticUrl("/images/icon.png");?>">
    <link rel="icon" href="<?=GlobalUrlService::buildStaticUrl("/images/icon.png");?>">
    <?php $this->head() ?>
    <?php $this->beginBody() ?>
</head>
<body>
<header class="main-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <a class="btn btn-default btn-run" href="javascript:void(0);">运行</a>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                &nbsp;
            </div>
        </div>
    </div>
</header>
<section class="content-wrap">
    <div class="container-fluid">
        <div class="row">
            <?php echo $content ?>
        </div>
    </div>
</section>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
