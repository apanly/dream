<?php

namespace blog\controllers;

use blog\controllers\common\BaseController;
use common\components\UtilHelper;
use common\models\applog\AccessLogs;
use Yii;


class LogController extends BaseController{
    public function actionAdd(){
        $referer = $this->get("referer","");
        $target_url = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"";
        if( $target_url ){
            $model_ac_log = new AccessLogs();
            $model_ac_log->referer = $referer;
            $model_ac_log->target_url = $target_url;
            $model_ac_log->user_agent = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:"";
            $model_ac_log->ip = UtilHelper::getClientIP();
            $model_ac_log->created_time = date("Y-m-d H:i:s");
            $model_ac_log->save();
        }
    }
}