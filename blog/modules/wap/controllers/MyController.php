<?php
namespace blog\modules\wap\controllers;

use blog\components\UrlService;
use blog\modules\wap\controllers\common\BaseController;

class MyController extends BaseController{

    public function actionAbout(){
        $this->setTitle("编程浪子的简介 -- 编程浪子的博客");
        return $this->render("about");
    }

    public function actionWechat(){
        return $this->redirect( UrlService::buildWapUrl("/my/about#contact") );
        $this->setTitle("编程浪子的联系方式 -- 编程浪子的博客");
        return $this->render("wechat");
    }
} 