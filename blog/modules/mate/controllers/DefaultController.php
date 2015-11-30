<?php

namespace blog\modules\mate\controllers;

use blog\modules\mate\controllers\common\BaseController;

class DefaultController extends BaseController
{
    public function actionIndex(){
        return $this->render("index");
    }
} 