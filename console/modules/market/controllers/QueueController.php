<?php

namespace console\modules\market\controllers;

use common\models\soft\SoftQueue;
use console\controllers\BaseController;

class QueueController extends BaseController {
	/**
	 * php yii soft/queue/run
	 */
	public function actionRun( ){
		$list = SoftQueue::find()->where([ 'status' => -1  ])->orderBy([ 'id' =>SORT_ASC ])->limit( 10 )->all();
		if( !$list ){
			return $this->echoLog( 'no data to handle ~~' );
		}

		foreach( $list as $_item ){
			$this->echoLog("queue_id:{$_item['id']}");
			sleep( 1 );
			switch ( $_item['queue_name'] ){
				case "sendMail":

					break;
			}
			$_item->status = 1;
			$_item->updated_time = date("Y-m-d H:i:s");
			$_item->update( 0 );
		}
		return $this->echoLog("it's over ~~");
	}

}
