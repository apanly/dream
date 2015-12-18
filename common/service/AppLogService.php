<?php

namespace common\service;


use common\components\UtilHelper;
use common\models\applog\AppLogs;

class AppLogService extends BaseService {

    public static function addLog(){
        $error = \Yii::$app->errorHandler->exception;
        if( !$error ){
            return true;
        }

        $code = $error->getCode();
        $msg = $error->getMessage();
        $file = $error->getFile();
        $line = $error->getLine();
        $host = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:"";
        $uri = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:"";
        $url = $host.$uri;

        $err_msg = $msg . " [file: {$file}][line: {$line}][err code:$code.][url:{$url}][post:".http_build_query($_POST)."]";
        $model_app_logs = new AppLogs();
        $model_app_logs->app_name = \Yii::$app->id;
        $model_app_logs->request_uri = $uri;
        $model_app_logs->content = $err_msg;
        $model_app_logs->ip = UtilHelper::getClientIP();
        $model_app_logs->ua = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:"";
        $model_app_logs->cookies = var_export($_COOKIE,true);
        $model_app_logs->created_time = date("Y-m-d H:i:s");
        $model_app_logs->save(0);
        return true;
    }
} 