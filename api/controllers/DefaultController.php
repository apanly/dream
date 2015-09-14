<?php

namespace api\controllers;

use common\components\UtilHelper;
use Yii;
use api\controllers\common\AuthController;

class DefaultController extends AuthController
{
    public function actionIndex(){

        return "Hi Guest,IP:".UtilHelper::getClientIP().",Time:".date('Y-m-d H:i:s');
    }

}