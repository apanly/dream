<?php
namespace blog\modules\wap\controllers;

use blog\modules\wap\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\user\User;
use common\models\user\UserMessageHistory;
use common\models\user\UserOpenidUnionid;
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
            ->limit(5)
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
                    "id" => $_item['id'],
                    "nickname" => DataHelper::encode( $tmp_user_info['nickname'] ),
                    "avatar" => $tmp_user_info['avatar']?$tmp_user_info['avatar']:GlobalUrlService::buildStaticUrl("/images/wap/no_avatar.png"),
                    "content" => DataHelper::encode( $_item['content'] ),
                    "created_time" => date("Y-m-d H:i",strtotime($_item['created_time']) )
                ];
            }
        }
        $this->layout  = "main";
        return $this->render("index",[
            "list" => $data
        ]);
    }

    public function actionGet_latest_message(){
        $max_id = intval( $this->post("max_id",0) );
        if( !$max_id ){
            return $this->renderJSON([],"",-1);
        }

        $info = UserMessageHistory::find()
            ->where([ 'status' => 1 ])
            ->andWhere([">","id",$max_id])
            ->orderBy("id desc")
            ->limit(1)
            ->one();

        if( !$info ){
            return $this->renderJSON();
        }

        $user_info = User::findOne( ['uid' => $info['uid'] ]);
        $data = [
            "id" => $info['id'],
            "nickname" => DataHelper::encode( $user_info['nickname'] ),
            "avatar" => $user_info['avatar']?$user_info['avatar']:GlobalUrlService::buildStaticUrl("/images/wap/no_avatar.png"),
            "content" => DataHelper::encode( $info['content'] ),
            "created_time" => date("Y-m-d H:i",strtotime($info['created_time']) )
        ];

        $html = <<<EOT
<li class="am-comment" data_id="{$data['id']}">
                <a href="javascript:void(0);">
                    <img src="{$data['avatar']}" alt="" class="am-comment-avatar" width="48" height="48"/>
                </a>
                <div class="am-comment-main">
                    <header class="am-comment-hd">
                        <div class="am-comment-meta">
                            <a href="javascript:void(0);" class="am-comment-author">{$data['nickname']}</a>
                            上墙于 <time>{$data['created_time']}</time>
                        </div>
                    </header>
                    <div class="am-comment-bd">
                        {$data['content']}
                    </div>
                </div>
            </li>
EOT;

        return $this->renderJSON( [ 'message' => $html ] );


    }

    public function actionSign(){

        /*初始化用户*/
        $woid = $this->get("woid",'');
        if( $woid ){
            $date_now = date("Y-m-d H:i:s");
            $bind_info = UserOpenidUnionid::findOne( [ 'other_openid' => strval($woid) ]  );
            if( !$bind_info ){
                $unique_name = md5($woid);
                $user_info  = User::findOne(['unique_name' => $unique_name]);
                if( !$user_info ){
                    $model_user = new User();
                    $model_user->nickname = "微信用户".substr($woid,-10);
                    $model_user->unique_name = $unique_name;
                    $model_user->updated_time = $date_now;
                    $model_user->created_time = $date_now;
                    $model_user->save(0);
                    $user_info = $model_user;
                }

                $model_bind = new UserOpenidUnionid();
                $model_bind->uid = $user_info['uid'];
                $model_bind->openid = $woid;
                $model_bind->unionid = '';
                $model_bind->other_openid = $woid;
                $model_bind->updated_time = $date_now;
                $model_bind->created_time = $date_now;
                $model_bind->save(0);
            }
        }

        return $this->render("sign",[
            "user_info" => $this->current_user
        ]);
    }
} 