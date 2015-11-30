<?php
namespace blog\modules\wap\controllers;

use blog\components\UrlService;
use blog\modules\wap\controllers\common\BaseController;

class MyController extends BaseController{

    public function actionAbout(){
        $this->setTitle("郭大帅哥的简介 -- 郭大帅哥的博客");
        return $this->render("about");
    }

    public function actionWechat(){
        return $this->redirect( UrlService::buildWapUrl("/my/about#contact") );
        $this->setTitle("郭大帅哥的联系方式 -- 郭大帅哥的博客");
        return $this->render("wechat");
    }
} 