<?php

namespace console\modules\blog\controllers;

use console\modules\blog\Blog;

class DefaultController extends Blog{
    public function actionIndex(){
        $this->echoLog("Yeah!!");
    }
}