<?php

namespace console\modules\market\controllers;

use common\models\soft\SoftQueue;
use common\service\soft\SoftService;
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
			$this->handleMail( $_item );
			$_item->status = 1;
			$_item->updated_time = date("Y-m-d H:i:s");
			$_item->update( 0 );
			sleep( 1 );
		}
		return $this->echoLog("it's over ~~");
	}

	private function handleMail( $queue_info ){
		$ret = SoftService::getDownInfoByPayId( $queue_info );
		if( !$ret ){
			return true;
		}
		$member_info = $ret['member_info'];
		$content = $this->renderPartial( "@console/modules/market/views/maildown.php",$ret );
		$mail= \Yii::$app->mailer->compose();
		$mail->setTo( $member_info['email'] );
		$mail->setSubject( "浪子商城自动发货" );
		$mail->setHtmlBody( $content );
		$mail->send();
	}

}
