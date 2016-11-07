<?php

namespace blog\controllers;

use blog\components\UrlService;
use blog\controllers\common\BaseController;
use blog\controllers\common\BlogException;
use common\components\UtilHelper;
use common\models\applog\AdCspReport;
use common\service\AppLogService;
use Yii;
use yii\log\FileTarget;

class ErrorController extends BaseController{
    public $enableCsrfValidation = false;

    public function actionError(){
        AppLogService::addLog();
        $reback_url = UrlService::buildUrl("/");
        if (preg_match("/^wap/", Yii::$app->request->getPathInfo())) {
            $reback_url = UrlService::buildWapUrl("/");
        }

        $this->layout = false;
        return $this->render("index",[
            "title" => "Page Not Found",
            "msg" => "404警告！ 很不幸，您探索了一个未知领域！",
            "reback_url" => $reback_url
        ]);
    }

    public function actionCapture(){
        $referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
        $url = $this->post("url","");
        $message = $this->post("message","");
        $error = $this->post("error","");
        $err_msg = "JS ERROR：[url:{$referer}],[js_file:{$url}],[error:{$message}],[error_info:{$error}]";
        AppLogService::addErrorLog("app-js",$referer,$err_msg);
    }

	public function actionCsp(){

		$content = file_get_contents("php://input");
		if( !$content && isset( $GLOBALS['HTTP_RAW_POST_DATA'] ) ){
			$content = $GLOBALS['HTTP_RAW_POST_DATA'];
		}

		$target = new AdCspReport();
		$target->url =  isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';;
		$target->ip = UtilHelper::getClientIP();
		$target->report_content = $content;
		$target->ua = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'';
		$target->updated_time = date("Y-m-d H:i:s");
		$target->created_time = date("Y-m-d H:i:s");
		$target->save(0);
	}
}

