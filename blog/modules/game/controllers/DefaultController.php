<?php

namespace blog\modules\game\controllers;

use blog\modules\game\controllers\common\BaseController;

class DefaultController extends BaseController
{
    public function actionIndex(){
        var_dump($this->getCookie("openid"));
    }
} 