<?php

namespace blog\controllers;

use blog\controllers\common\BaseController;
use common\service\bat\QQMusicService;
use Yii;

class TestController extends BaseController{
    public function actionIndex(){
        $this->layout = false;
        return $this->render("index");
    }
}