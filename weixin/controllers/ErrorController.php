<?php

namespace weixin\controllers;

use common\service\AppLogService;
use common\service\GlobalUrlService;

class ErrorController extends \common\components\BaseWebController{
    public function actionError() {
		AppLogService::addLog();

		return $this->redirect( GlobalUrlService::buildWeixinUrl( "/" ) )->send();
		//\Yii::$app->response->send();
    }
}

