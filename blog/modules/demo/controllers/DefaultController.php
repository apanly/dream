<?php

namespace blog\modules\demo\controllers;

use blog\modules\demo\controllers\common\BaseController;

class DefaultController extends BaseController{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
