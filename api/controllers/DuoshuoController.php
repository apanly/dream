<?php

namespace api\controllers;

use common\components\UtilHelper;
use Yii;
use api\controllers\common\AuthController;

class DuoshuoController extends AuthController
{
    public function actionCallback(){
        $this->recode(var_export($_POST,true));
    }

}