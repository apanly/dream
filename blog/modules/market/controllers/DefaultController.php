<?php

namespace blog\modules\market\controllers;

use blog\modules\market\controllers\common\BaseController;
use common\models\soft\Soft;

/**
 * http://www.shafa.com/ 模板
 */

class DefaultController extends BaseController {

    public function actionIndex(){


    	$mina_list = Soft::find()->where([ 'type' => 1,'status' => 1 ])
			->orderBy([ 'id' => SORT_DESC ])->limit( 8 )->all();

        return $this->render('index',[
        	'mina_list' => $mina_list
		]);
    }
}
