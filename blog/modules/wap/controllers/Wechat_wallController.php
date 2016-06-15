<?php
namespace blog\modules\wap\controllers;

use blog\modules\wap\controllers\common\BaseController;
use common\models\user\User;
use common\models\weixin\WxHistory;

class Wechat_wallController extends BaseController{

    public function __construct($id, $module, $config = []){
        parent::__construct($id, $module, $config = []);
        $this->setTitle("微信墙");
        $this->layout = "@blog/modules/wap/views/{$id}/layout.php";
        $view = \Yii::$app->view;
        $view->params['logo'] = '';
    }

    public function actionIndex(){
        $list = WxHistory::find()
            ->where(['type' => 'text'])
            ->orderBy("id desc")
            ->limit(10);
        $data = [];
        if( $list ){
            $user_list = User::find()->all();
            
            foreach( $list as $_item ){

            }
        }

        $this->layout  = "main";
        return $this->render("index");
    }

    public function actionSign(){
        return $this->render("sign",[
            "user_info" => $this->current_user
        ]);
    }
} 