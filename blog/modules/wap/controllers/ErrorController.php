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
}