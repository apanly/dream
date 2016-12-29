<?php

namespace awephp\controllers;

use common\components\DataHelper;
use common\components\UtilHelper;

use Yii;
use awephp\controllers\common\AuthController;

class DocsController extends AuthController{
    public function actionIndex(){
        return $this->render("index");
    }
}