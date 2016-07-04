<?php

namespace blog\controllers;

use blog\controllers\common\BaseController;
use common\service\libs\MetaWeblogService;
use common\service\SyncBlogService;
use Yii;

class TestController extends BaseController{
    public function actionIndex(){
        return $this->render("index");
    }


}