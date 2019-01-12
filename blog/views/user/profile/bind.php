<?php
use \blog\components\StaticService;
use \common\service\GlobalUrlService;
?>
<?php echo \Yii::$app->view->renderFile("@blog/views/user/profile/side.php",[  'current' => 'bind' ]);?>
<div class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3 col-lg-9 col-lg-offset-3 main">
    <h1 class="page-header">绑定第三方账号</h1>
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <p>敬请期待，功能正在开发中</p>
        <p>将会集成 QQ、微博、Github登录</p>
    </div>
</div>
