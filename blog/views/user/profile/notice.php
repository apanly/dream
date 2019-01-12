<?php
use \blog\components\StaticService;
use \common\service\GlobalUrlService;
?>
<?php echo \Yii::$app->view->renderFile("@blog/views/user/profile/side.php",[  'current' => 'notice' ]);?>
<div class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3 col-lg-9 col-lg-offset-3 main">
    <h1 class="page-header">订阅设置</h1>
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <p>敬请期待，功能正在开发中</p>
        <p>本功能目的是为了当系统有更新内容的时候，希望通过某几种方式推送给大家</p>
    </div>
</div>
