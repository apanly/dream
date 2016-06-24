<?php

namespace admin\components;

use common\components\UtilHelper;
use common\models\applog\AdminAccessLog;
use common\service\BaseService;

class AccessLogService extends BaseService{

    public static function recordAccess_log($params){
        $target_type = isset( $params['target_type'] )?$params['target_type']:0;
        $target_id = isset( $params['target_id'] )?$params['target_id']:0;
        $act_type = isset( $params['act_type'] )?$params['act_type']:0;
        $note = isset( $params['note'] )?$params['note']:[];
        $status = isset( $params['status'] )? $params['status']:1;
        $login_name = isset( $params['login_name'] )?$params['login_name']:'';

        $get_params = \Yii::$app->request->get();
        $post_params = \Yii::$app->request->post();

        if( isset( $get_params['passwd'] ) ){
            unset( $get_params['passwd'] );
        }

        if( isset( $post_params['passwd'] ) ){
            unset( $post_params['passwd'] );
        }

        $access_log = new AdminAccessLog();
        $access_log->target_type = $target_type;
        $access_log->act_type = $act_type;
        $access_log->login_name = $login_name;
        $access_log->target_id = $target_id;
        $access_log->refer_url = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
        $access_log->target_url = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'';
        $access_log->query_params = json_encode(array_merge($get_params,$post_params));
        $access_log->ua = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'';
        $access_log->ip = UtilHelper::getClientIP();
        $access_log->note = json_encode($note);
        $access_log->status = $status;
        $access_log->created_time = date("Y-m-d H:i:s");
        $access_log->save(0);
    }

}