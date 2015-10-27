<?php

namespace api\controllers;

use common\components\UtilHelper;
use Yii;
use api\controllers\common\AuthController;

class DuoshuoController extends AuthController
{
    public function actionCallback(){
        $request = Yii::$app->request;
        if( $request->isPost ){
            $this->recode(var_export($_POST,true));
        }
        return $this->renderJSON()
    }

}