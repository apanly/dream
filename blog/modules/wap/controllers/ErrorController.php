<?php

namespace blog\modules\wap\controllers;

use blog\components\UrlService;
use blog\modules\wap\controllers\common\BaseController;
use common\service\AppLogService;
use Yii;

class ErrorController extends BaseController{
    public function actionError(){
        AppLogService::addLog();
        $reback_url = UrlService::buildWapUrl("/");
        $this->layout = false;
        return $this->render("@blog/views/error/index.php",[
            "title" => "Page Not Found",
            "msg" => "404警告！ 很不幸，您探索了一个未知领域！",
            "reback_url" => $reback_url
        ]);
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