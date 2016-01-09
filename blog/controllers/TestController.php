<?php

namespace blog\controllers;

use blog\controllers\common\BaseController;
use common\service\libs\MetaWeblogService;
use common\service\SyncBlogServince;
use Yii;

class TestController extends BaseController{
    public function actionIndex(){
        //SyncBlogServince::doSync("sina",15);
    }


}