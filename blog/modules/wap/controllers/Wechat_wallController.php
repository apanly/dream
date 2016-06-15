<?php
namespace blog\modules\wap\controllers;

use blog\modules\wap\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\user\User;
use common\models\user\UserMessageHistory;
use common\models\weixin\WxHistory;
use common\service\GlobalUrlService;

class Wechat_wallController extends BaseController{

    public function __construct($id, $module, $config = []){
        parent::__construct($id, $module, $config = []);
        $this->setTitle("微信墙");
        $this->layout = "@blog/modules/wap/views/{$id}/layout.php";
        $view = \Yii::$app->view;
        $view->params['logo'] = '';
    }

    public function actionIndex(){
        $list = UserMessageHistory::find()
            ->where(['status' => 1 ])
            ->orderBy("id desc")
            ->limit(10)
            ->all();
        $data = [];
        if( $list ){
            $user_mapping = DataHelper::getDicByRelateID($list,User::className(),"uid","uid",["nickname","avatar"]);
            foreach( $list as $_item ){
                if( !isset( $user_mapping[ $_item['uid'] ] ) ){
                    continue;
                }
                $tmp_user_info = $user_mapping[ $_item['uid'] ];
                $data[] = [
                    "nickname" => DataHelper::encode( $tmp_user_info['nickname'] ),
                    "avatar" => $tmp_user_info['avatar']?$tmp_user_info['avatar']:GlobalUrlService::buildStaticUrl("/images/wap/no_avatar.png"),
                    "content" => DataHelper::encode( $_item['content'] ),
                    "created_time" => date("Y-m-d H:",strtotime($_item['created_time']) )
                ];
            }
        }
        $this->layout  = "main";
        return $this->render("index",[
            "list" => $data
        ]);
    }

    public function actionGetLatestMessage(){
        $max = $this->post("id",0);
        
    }

    public function actionSign(){
        return $this->render("sign",[
            "user_info" => $this->current_user
        ]);
    }
} 