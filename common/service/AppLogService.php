<?php

namespace common\service;


use common\components\UtilHelper;
use common\models\applog\AdCspReport;
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
        $referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
        $url = $host.$uri;

        $err_msg = $msg . " [file: {$file}][line: {$line}][err code:$code.][url:{$url}][referer:{$referer}][post:".http_build_query($_POST)."]";
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

    public static function addErrorLog($appid,$uri,$err_msg){

        $model_app_logs = new AppLogs();
        $model_app_logs->app_name = $appid;
        $model_app_logs->request_uri = $uri;
        $model_app_logs->content = $err_msg;
        $model_app_logs->ip = UtilHelper::getClientIP();
        $model_app_logs->ua = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:"";
        $model_app_logs->cookies = var_export($_COOKIE,true);
        $model_app_logs->created_time = date("Y-m-d H:i:s");
        $model_app_logs->save(0);
        return true;
    }

    public static function addCspReport( $content ){
		$json_content = @json_decode( $content,true );
		$target = new AdCspReport();
		$target->url =  isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';;
		$target->ip = UtilHelper::getClientIP();
		$target->report_content = $content;
		if( $json_content && isset($json_content['csp-report']) ){
			if( isset( $json_content['csp-report']['blocked-uri']) ){
				$blocked_uri = parse_url( $json_content['csp-report']['blocked-uri'] );
				$tmp_port = isset( $blocked_uri['port'] )?$blocked_uri['port']:'';
				$blocked_uri = $blocked_uri['host'];
				if( $tmp_port ){
					$blocked_uri .= ":{$tmp_port}";
				}
				$target->blocked_uri = $blocked_uri;
			}

			if( isset( $json_content['csp-report']['source-file']) ){
				$target->source_file = $json_content['csp-report']['source-file'];
			}
		}
		$target->ua = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'';
		$target->updated_time = date("Y-m-d H:i:s");
		$target->created_time = date("Y-m-d H:i:s");
		$target->save(0);
	}
} 