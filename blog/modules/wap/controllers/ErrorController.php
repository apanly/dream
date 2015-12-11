<?php

namespace blog\modules\wap\controllers;

use blog\components\UrlService;
use blog\modules\wap\controllers\common\BaseController;
use Yii;

class ErrorController extends BaseController{
    public function actionError(){
        return $this->redirect( UrlService::buildWapUrl("/") );
    }
}