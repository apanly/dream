<?php

namespace blog\controllers;

use blog\controllers\common\BaseController;
use common\service\bat\QQMusicService;
use common\service\SyncBlogServince;
use Yii;

class TestController extends BaseController{
    public function actionIndex(){
        //SyncBlogServince::sync251cto();
        //SyncBlogServince::sync2csdn();
        //SyncBlogServince::sync2sina();
        //SyncBlogServince::sync2163();
        //SyncBlogServince::sync2oschina();
        SyncBlogServince::sync2cnblogs();
    }


}