<?php
/**
 * Class BaseController
 */

namespace console\controllers;


use common\models\soft\Soft;

class BaseController extends  \yii\console\Controller {
    public function echoLog($msg){
        echo date("Y-m-d H:i:s")." ".$msg."\r\n";
        return true;
    }

	public function insertSoft( $item ){

    	$has_in = Soft::find()->where([ 'origin_info_url' => $item['info_url'] ])->count();
    	if( $has_in ){
    		return true;
		}

    	$model_soft = new Soft();
		$model_soft->setUniqueSn();
		$model_soft->type = $item['type'];
		$model_soft->title = $item['title'];
		$model_soft->content = '';
		$model_soft->image_url = $item['img_url'];
		$model_soft->origin_info_url = $item['info_url'];
		$model_soft->updated_time = $model_soft->created_time = date("Y-m-d H:i:s");
		return $model_soft->save( 0 );
	}
} 