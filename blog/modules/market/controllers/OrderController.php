<?php

namespace blog\modules\market\controllers;

use blog\modules\market\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\soft\Soft;
use common\service\Constant;
use common\service\GlobalUrlService;



class OrderController extends BaseController {

    public function actionBuy(){
		if( !\Yii::$app->request->isPost ){
			return $this->renderJSON( [],"系统繁忙，请稍后再试~~",-1 );
		}

		$info  = Soft::findOne([ 'id' => 1 ]);
    }
}
