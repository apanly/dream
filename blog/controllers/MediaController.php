<?php

namespace blog\controllers;

use blog\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\posts\Posts;
use Yii;
use yii\helpers\Url;


class MediaController extends BaseController
{
    public function actionIndex(){
        return $this->render("index");
    }

}