<?php
namespace common\service\soft;


use common\models\pay\PayOrder;
use common\models\pay\PayOrderItem;
use common\models\soft\Soft;
use common\models\soft\SoftQueue;
use common\models\soft\SoftSaleChangeLog;
use common\models\user\Member;
use common\service\BaseService;

class SoftService extends BaseService {

	public static function confirmOrderItem( $order_item_id ){
		$order_item_info = PayOrderItem::findOne(['id' => $order_item_id,'status' => 1]);
		if( !$order_item_info  ){
			return false;
		}

		$order_info  = PayOrder::findOne(['id' => $order_item_info["pay_order_id"] ]);
		if( !$order_info ){
			return false;
		}

		$model_sale_change_log = new SoftSaleChangeLog();
		$model_sale_change_log->soft_id = $order_item_info['target_id'];
		$model_sale_change_log->quantity = $order_item_info['quantity'];
		$model_sale_change_log->price = $order_item_info['price'];
		$model_sale_change_log->member_id = $order_item_info['member_id'];
		$model_sale_change_log->created_time = date("Y-m-d H:i:s");
		if( $model_sale_change_log->save( 0 ) ){
			self::updateApplyNumber( $order_item_info['target_id'] );
		}

		return true;
	}

	public static function updateApplyNumber( $id ){
		$info = Soft::findOne([  'id' => $id  ]);
		if( $info ){
			//'apply_number' => 1  , =1 每次加1 ，= -1 每次减1
			Soft::updateAllCounters( [ 'apply_number' => 1 ], [ 'id' => $id ]);
		}
		return true;
	}

	public static function addQueue( $queue_name,$params = [] ){
		try{
			$member_id = isset( $params['member_id'] ) ? $params['member_id']:0;
			$pay_order_id = isset( $params['pay_order_id'] ) ? $params['pay_order_id']:0;
			$data = isset( $params['data'] ) ? $params['data']:[];
			if( !$member_id || !$pay_order_id ){
				return self::_err( "member_id或者pay_order_id 不合法~~" );
			}
			$model_queue = new SoftQueue();
			$model_queue->member_id = $member_id;
			$model_queue->pay_id = $pay_order_id;
			$model_queue->data = json_encode( $data );
			$model_queue->created_time = $model_queue->updated_time = date("Y-m-d H:i:s");
			$model_queue->save( 0 );
		}catch (Exception $e) {
			return self::_err( $e->getMessage() );
		}
		return true;
	}

	public static function getDownInfoByPayId( $queue_info ){
		$ret = [];
		if( !$queue_info['member_id'] || !$queue_info['pay_id'] ){
			return $ret;
		}
		$member_info = Member::findOne([ 'id' => $queue_info['member_id'] ]);
		if( !$member_info ){
			return $ret;
		}
		$order_info = PayOrder::findOne([ 'id' => $queue_info['pay_id'],'status' => 1,"member_id" => $member_info['id']  ]);
		if( !$order_info ){
			return $ret;
		}
		$order_item_list = PayOrderItem::find()->where([ 'pay_order_id' =>  $order_info['id'] ])->asArray()->all();
		if( !$order_item_list ){
			return $ret;
		}


		$soft_list = [];
		$soft_mapping = Soft::find()->select([ 'id','title','down_url' ])->where([ 'id' => array_column( $order_item_list,"target_id" ) ])->indexBy("id")->all();
		foreach( $order_item_list as $_order_item_info ){
			if( !isset( $soft_mapping[ $_order_item_info['target_id'] ] ) ){
				continue;
			}
			$tmp_soft_info = $soft_mapping[ $_order_item_info['target_id'] ];
			$soft_list[] = [
				'title' => $tmp_soft_info['title'],
				'down_url' => $tmp_soft_info['down_url']
			];
		}

		$ret = [
			"member_info" => $member_info,
			"items" => $soft_list
		];
		return $ret;
	}
}