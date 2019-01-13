<?php

namespace common\service;


use common\models\pay\PayOrder;
use common\models\pay\PayOrderItem;
use common\models\soft\Soft;
use common\service\soft\SoftService;
use common\service\Constant;
use common\service\BaseService;
use \Exception;

class PayOrderService extends  BaseService {

	/**
	 * 创建订单
	 */
	public static function createPayOrder( $member_id,$items = [],$params = []){
		$total_price = 0;
		$continue_cnt = 0;
		foreach( $items as $_item ){
			if( $_item['price'] < 0 ){
				$continue_cnt += 1;
				continue;
			}
			$total_price += $_item['price'];
		}

		if( $continue_cnt >= count($items) ){
			return self::_err( "商品items为空~~" );
		}

		$discount = isset( $params['discount'] )?$params['discount']:0;
		$total_price = sprintf("%.2f",$total_price);
		$discount = sprintf("%.2f",$discount);
		$pay_price = $total_price - $discount;
		$pay_price = sprintf("%.2f",$pay_price);

		$date_now = date("Y-m-d H:i:s");
		$connection =  PayOrder::getDb();
		$transaction = $connection->beginTransaction();
		try{
			$model_pay_order = new PayOrder();
			$model_pay_order->order_sn = self::generate_order_sn();
			$model_pay_order->member_id = $member_id;
			$model_pay_order->pay_type = isset($params['pay_type'])?$params['pay_type']:0;
			$model_pay_order->pay_source = isset($params['pay_source'])?$params['pay_source']:0;
			$model_pay_order->target_type = isset($params['target_type'])?$params['target_type']:0;
			$model_pay_order->total_price = $total_price;
			$model_pay_order->discount = $discount;
			$model_pay_order->pay_price = $pay_price;
			$model_pay_order->note = isset($params['note'])?$params['note']:'';
			$model_pay_order->status = isset($params['status'])?$params['status']:-8;
			$model_pay_order->queue_status = isset($params['queue_status'])?$params['queue_status']:-8;
			$model_pay_order->pay_time = Constant::$default_time_stamps;
			$model_pay_order->updated_time = $date_now;
			$model_pay_order->created_time = $date_now;
			if( !$model_pay_order->save(0) ){
				throw new Exception("创建订单失败~~");
			}

			foreach($items as $_item){
				$new_item = new PayOrderItem();
				$new_item->pay_order_id = $model_pay_order->id;
				$new_item->member_id = $member_id;
				$new_item->quantity  = $_item['quantity'];
				$new_item->price  = $_item['price'];
				$new_item->target_type  = $_item['target_type'];
				$new_item->target_id  = $_item['target_id'];
				$new_item->status = isset($_item['status'])?$_item['status']:1;

				if( isset( $_item['extra_data'] ) ){
					$new_item->extra_data = json_encode( $_item['extra_data'] );
				}

				$new_item->note = isset( $_item['note'] )?$_item['note']:"";
				$new_item->updated_time = $date_now;
				$new_item->created_time  = $date_now;
				if( !$new_item->save(0) ){
					throw new Exception("创建订单失败~~");
				}
			}

			$transaction->commit();

			return [
				'id' => $model_pay_order->id,
				'order_sn' => $model_pay_order->order_sn,
				'pay_money' => $model_pay_order->pay_price,
			];

		}catch (Exception $e) {
			$transaction->rollBack();
			return self::_err( $e->getMessage() );
		}
	}

	/**
	 * 订单成功之后操作
	 */

	public static function orderSuccess($pay_order_id,$params = []){

		$date_now = date("Y-m-d H:i:s");
		$connection = PayOrder::getDb();
		$transaction = $connection->beginTransaction();
		try {
			$pay_order_info = PayOrder::findOne( $pay_order_id );
			if( !$pay_order_info || !in_array( $pay_order_info['status'],[-8,-7] ) ){//只有-8，-7状态才可以操作
				return self::_err( "订单状态不对~~" );
			}

			$pay_order_info->pay_sn = isset($params['pay_sn'])?$params['pay_sn']:"";
			$pay_order_info->status = 1;
			$pay_order_info->queue_status = -2;
			$pay_order_info->pay_time = $date_now;
			$pay_order_info->updated_time = $date_now;
			$pay_order_info->update(0);
			$items = PayOrderItem::findAll( [ 'pay_order_id' => $pay_order_id ] );

			foreach($items as $_item){
				switch( $_item->target_type ){
					case 1://商城软件
						SoftService::confirmOrderItem( $_item['id'] );
						break;
					case 2:
						break;
				}
			}

			$transaction->commit();

		} catch (Exception $e) {
			$transaction->rollBack();
			return self::_err( $e->getMessage() );
		}

		//入队列给别人发邮件
		SoftService::addQueue( "pay",[
			'member_id' => $pay_order_info['member_id'],
			'pay_order_id' => $pay_order_info['id'],
		] );
		return true;

	}

	/**
	 * 关闭订单
	 */
	public static function closeOrder( $pay_order_id = 0 ){
		$date_now = date("Y-m-d H:i:s");
		$pay_order_info = PayOrder::find()->where([ 'id' => $pay_order_id,'status' => -8 ])->one();
		if( !$pay_order_info ){
			return self::_err("指定订单不存在");
		}

		$pay_order_info->status = 0;
		$pay_order_info->updated_time = $date_now;
		return $pay_order_info->update(0);
	}

	public static function generate_order_sn(){
		do{
			$sn = md5(microtime(1).rand(0,9999999).'!@%egg#$');

		}while( PayOrder::findOne( [ 'order_sn' => $sn ] ) );

		return $sn;
	}
}