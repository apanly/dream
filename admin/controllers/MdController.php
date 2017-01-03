<?php

namespace admin\controllers;

use admin\controllers\common\BaseController;
use Yii;

class MdController extends BaseController{
	public function actionIndex(){
		return $this->render("index");
	}

	public function actionSet(){
		return $this->render("set");
	}
}

