<?php
namespace common\service\weixin;

use common\models\weixin\WxQueueList;
use common\service\BaseService;


class WxQueueListService extends BaseService {

	public static function addQueue( $queue_name,$data = []){
		$model = new WxQueueList();
		$model->queue_name = $queue_name;
		$model->data = json_encode( $data );
		$model->status = -1;
		$model->created_time = $model->updated_time = date("Y-m-d H:i:s");
		return $model->save( 0 );
	}

}