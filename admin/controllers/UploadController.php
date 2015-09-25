<?php

namespace admin\controllers;

use admin\controllers\common\BaseController;
use Yii;
use common\models\user\User;

class UploadController extends BaseController
{

    public function actionPost(){
        var_dump($_FILES);
    }


}