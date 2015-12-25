<?php

namespace blog\controllers;

use blog\controllers\common\BaseController;
use common\service\bat\QQMusicService;
use Yii;

class TestController extends BaseController{
    public function actionIndex(){
        $data = [
            "code" => 0,
            "data" => [
                "104795185" => "104795185|104795185|104795185"
            ],
            "url" => [
                "url" => "safsfds"
            ],
            "url1" => [

            ]
        ];
        var_dump( json_encode($data) );

    }
}