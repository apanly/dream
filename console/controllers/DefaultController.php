<?php


namespace console\controllers;


class DefaultController extends  BaseController {
	public function actionIndex(){
		\Tinify\setKey( \Yii::$app->params['tinypng']['ak'] );
		$source = \Tinify\fromFile("/home/www/yii/dream/static/web/images/pay/pay.jpg");
		$source->toFile("optimized.jpg");
		//$sourceData = file_get_contents("unoptimized.jpg");
		//$resultData = \Tinify\fromBuffer($sourceData)->toBuffer();
		//$source = \Tinify\fromUrl("https://cdn.tinypng.com/images/panda-happy.png");
		//$source->toFile("optimized.jpg");
	}
}
