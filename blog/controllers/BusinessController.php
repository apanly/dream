<?php
namespace blog\controllers;


use blog\controllers\common\BaseController;

class BusinessController extends  BaseController {
	public function actionIndex(){
		return $this->render("index");
	}
}