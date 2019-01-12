<?php
use \blog\components\StaticService;
use \common\service\GlobalUrlService;
use  \common\components\DataHelper;
?>
<?php echo \Yii::$app->view->renderFile("@blog/views/user/profile/side.php",[  'current' => 'index' ]);?>
<div class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3 col-lg-9 col-lg-offset-3 main">
    <h1 class="page-header">个人信息</h1>
    <div class="panel panel-default">
        <div class="panel-body">
            <p>登录名：<?=DataHelper::encode( $this->params['current_member']['login_name'] );?></p>
            <p>邮箱：<?=DataHelper::encode( $this->params['current_member']['email'] );?></p>
            <p>注册时间：<?=DataHelper::encode( $this->params['current_member']['created_time'] );?></p>
        </div>
    </div>
</div>