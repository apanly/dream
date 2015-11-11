<?php

namespace blog\modules\game\controllers;

use blog\modules\game\controllers\common\BaseController;

class MvController extends BaseController
{
    public function actionIndex(){
        var_dump($this->getCookie("openid"));
        return $this->render("index",[
            "auth" => $this->getCookie($this->auth_cookie_name)
        ]);
    }
} 