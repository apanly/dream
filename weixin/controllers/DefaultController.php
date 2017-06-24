<?php

namespace weixin\controllers;

use common\components\UtilHelper;

class DefaultController  extends \common\components\BaseWebController{
	public function actionIndex(){
		return "[".\Yii::$app->id."] Guest,IP:".UtilHelper::getClientIP().",Time:".date('Y-m-d H:i:s');
	}
}