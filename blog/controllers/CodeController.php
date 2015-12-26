<?php

namespace blog\controllers;

use blog\controllers\common\BaseController;
use Yii;


class CodeController extends BaseController{
    public function actionRun(){
        $this->layout = "codemirror";
        return $this->render("run");
    }
}