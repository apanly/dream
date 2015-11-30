<?php
namespace blog\modules\wap\controllers;

use blog\modules\wap\controllers\common\BaseController;

class GallaryController extends BaseController {

    public function actionIndex(){
        return $this->render("index");
    }
} 