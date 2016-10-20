<?php

namespace admin\controllers;

use admin\controllers\common\BaseController;

class TestController extends BaseController{
	public function actionIndex(){
		$this->layout = 'v1';
		return $this->render("index");
	}
}