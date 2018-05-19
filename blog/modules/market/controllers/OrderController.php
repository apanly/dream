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
		$id = intval( $this->post( "id",0 ) );
		if( $id < 1 ){
			return $this->renderJSON( [],"系统繁忙，请稍后再试~~",-1 );
		}

		$info  = Soft::findOne([ 'id' => $id ]);
		if( !$info ){
			return $this->renderJSON( [],"系统繁忙，请稍后再试~~",-1 );
		}

		$down_url = $info['down_url'];
		$msg = "自动领取功能还没有实现，请先按照提示自行下载哦~~<br/>{$down_url}";
		return $this->renderJSON( [],$msg );
    }
}
