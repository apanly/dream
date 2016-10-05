<?php
namespace blog\modules\wap\controllers;

use blog\components\UrlService;
use blog\modules\wap\controllers\common\BaseController;

class MyController extends BaseController{

    public function actionAbout(){
        $this->setTitle("简介");
        return $this->render("about");
    }

    public function actionWechat(){
        return $this->redirect( UrlService::buildWapUrl("/my/about#contact") );
    }

    public function actionEmoticon(){
        return $this->render("emoticon");
    }
} 