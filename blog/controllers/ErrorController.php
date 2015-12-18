<?php

namespace blog\controllers;

use blog\components\UrlService;
use blog\controllers\common\BaseController;
use blog\controllers\common\BlogException;
use common\service\AppLogService;
use Yii;
use yii\log\FileTarget;

class ErrorController extends BaseController
{
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


}

