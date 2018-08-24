<?php

namespace api\modules\mina\controllers\common;

use Yii;

class BaseMinaController extends \yii\web\Controller
{
	public $page_size = 10;

	public function beforeAction($action){
		return true;
	}


	protected function geneReqId(){
		return uniqid();
	}

	public static function post($key, $default = ""){
		return Yii::$app->request->post($key, $default);
	}


	public static function get($key, $default = ""){
		return Yii::$app->request->get($key, $default);
	}

	protected function renderJSON($data = [], $msg = "ok", $code = 200){
		header('Content-type: application/json');
		echo json_encode([
			"code"   => $code,
			"msg"    => $msg,
			"data"   => $data,
			"req_id" => $this->geneReqId(),
		]);


		return Yii::$app->end();
	}
}