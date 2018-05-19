<?php

namespace blog\modules\game\controllers;

use blog\components\UrlService;
use blog\modules\game\controllers\common\BaseController;

class DefaultController extends BaseController
{
    public function actionIndex(){
		return $this->redirect( UrlService::buildGameUrl( "/music/index" ) );
    }
} 