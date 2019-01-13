<?php

namespace blog\modules\market\controllers;

use blog\modules\market\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\pay\PayOrder;
use common\models\pay\PayOrderItem;
use common\models\soft\Soft;
use common\service\Constant;
use common\service\GlobalUrlService;
use common\service\PayOrderService;


class OrderController extends BaseController {

    public function actionBuy(){
		if( !\Yii::$app->request->isPost ){
			return $this->renderJSON( [],Constant::$default_syserror,-1 );
		}
		$id = intval( $this->post( "id",0 ) );
		if( $id < 1 ){
			return $this->renderJSON( [],Constant::$default_syserror,-1 );
		}

		$info  = Soft::findOne([ 'id' => $id ]);
		if( !$info ){
			return $this->renderJSON( [],Constant::$default_syserror,-1 );
		}

//		$down_url = $info['down_url'];
//		$msg = "自动领取功能还没有实现，请先按照提示自行下载哦~~<br/>{$down_url}";
		$target_type = 1;
		$quantity = 1;
		$need_buy = $info['need_buy'];
		$price = $info['price'];
		$discount = 0;
		if( $need_buy &&  $info['apply_number'] < $info['free_number']){
			$discount = $price;
		}

		$item = [
			'price' => $price,
			'quantity' => $quantity,
			'target_type' => $target_type,
			'target_id' => $info['id']
		];

		$items = [ $item ];

		$params = [
			'pay_type' => 1,
			'pay_source' => 1,
			'target_type' => $target_type,
			'note' => '浪子商城购买软件',
			'status' => -8,
			'discount' => $discount,
		];

		$ret = PayOrderService::createPayOrder( $this->current_member['id'],$items,$params );

		if( !$ret ){
			return $this->renderJSON([],"提交失败，失败原因：".PayOrderService::getLastErrorMsg(),-1 );
		}

		return $this->renderJSON([ 'url' => GlobalUrlService::buildSuperMarketUrl("/order/pay/?pay_sn={$ret['order_sn']}") ],'下单成功,前去支付~~' );
    }

    public function actionPay(){
    	if( \Yii::$app->request->isGet ){
    		$url = GlobalUrlService::buildSuperMarketUrl("/");
    		$order_sn = $this->get("pay_sn","");
			if( !$order_sn ){
				return $this->redirect( $url );
			}

			$pay_order_info = PayOrder::findOne([ 'order_sn' => $order_sn,'member_id' => $this->current_member['id'] ]);
			if( !$pay_order_info ){
				return $this->redirect( $url );
			}


			if( $pay_order_info['status'] == 0 ){
    			return $this->redirect( GlobalUrlService::buildSuperMarketUrl("/order/my" ) );
			}

			$order_item_list = PayOrderItem::find()->where([ 'pay_order_id' =>  $pay_order_info['id'] ])->asArray()->all();
    		$soft_list = [];
    		if( $order_item_list ){
				$soft_mapping = Soft::find()->select([ "id",'title' ])->where([ 'id' => array_column( $order_item_list,"target_id" ) ])->indexBy("id")->all();
				foreach( $order_item_list as $_order_item_info ){
					$tmp_soft_info = $soft_mapping[ $_order_item_info['target_id'] ];
					$soft_list[] = [
						'title' => $tmp_soft_info['title'],
						'quantity' => $_order_item_info['quantity']
					];
				}
			}
			$data = [
				"order_sn" => $pay_order_info['order_sn'],
				"created_time" => $pay_order_info['created_time'],
				"pay_time" => $pay_order_info['pay_time'],
				"status" => $pay_order_info['status'],
				"status_desc" => Constant::$pay_status_mapping[ $pay_order_info['status'] ],
				"total_price" => $pay_order_info['total_price'],
				"discount" => $pay_order_info['discount'],
				"pay_price" => $pay_order_info['pay_price'],
				"items" => $soft_list
			];

    		return $this->render("pay",[ "info" => $data ]);
		}

		$order_sn = $this->post("pay_sn","");
		if( !$order_sn ){
			return $this->renderJSON( [],Constant::$default_syserror,-1 );
		}

		$pay_order_info = PayOrder::findOne([ 'order_sn' => $order_sn,'member_id' => $this->current_member['id'] ]);
		if( !$pay_order_info ){
			return $this->renderJSON( [],Constant::$default_syserror,-1 );
		}

		if( $pay_order_info['status'] != -8 ){
			return $this->renderJSON( [  ],"订单已支付，请不要重复支付~~",-1 );
		}


		if( $pay_order_info['pay_price'] > 0 ){
			$image_pay = GlobalUrlService::buildPicStaticUrl("pic1","/20190113/336960964add9241b07364757e0e854e.jpg");
			$image_pay = "http://cdn.pic1.54php.cn/20190113/336960964add9241b07364757e0e854e.jpg?imageView/2/w/600";
			$pop_content = <<<EOF
<p><img src='{$image_pay}'/></p>
<p class='text-danger' style="text-align: center;">目前不支持在线支付，请直接扫码转账。请在转账备注填写：{$this->current_member['login_name']} 或者 {$this->current_member['email']}<br/>转账之后比较紧急请点击最上面 联系浪子 获取联系方式</p>
EOF;
			return $this->renderJSON([ 'content' => $pop_content ],"",201);
		}

		$ret = PayOrderService::orderSuccess( $pay_order_info['id'] );
		$msg = "支付成功，请稍等1 ~ 5分钟查看邮件~~";
		if( !$ret ){
			$msg = PayOrderService::getLastErrorMsg();
		}
		return $this->renderJSON([],$msg );
	}

	public function actionMy(){
		$page_size = 30;
		$p = intval( $this->get("p",1) );
		$p = ( $p > 0 )?$p:1;
		$query = PayOrder::find()->where([ 'member_id' => $this->current_member['id'] ]);

		$offset = ($p - 1) * $page_size;
		$total_res_count = $query->count();

		$pages = DataHelper::ipagination([
			'total_count' => $total_res_count,
			'page_size' => $page_size,
			'page' => $p,
			'display' => 10
		]);

		$list = $query->orderBy([ 'id' => SORT_DESC ])
			->offset($offset)
			->limit($page_size)
			->asArray()
			->all( );

		$data = [];

		if( $list ){
			$order_item_list = PayOrderItem::find()->where([ 'pay_order_id' =>  array_column( $list,"id" ) ])->asArray()->all();
			$soft_mapping = Soft::find()->select([ "id",'title' ])->where([ 'id' => array_column( $order_item_list,"target_id" ) ])->indexBy("id")->all();
			$pay_order_mapping = [];
			foreach( $order_item_list as $_order_item_info ){
				$tmp_soft_info = $soft_mapping[ $_order_item_info['target_id'] ];
				if( !isset( $pay_order_mapping[ $_order_item_info['pay_order_id'] ] ) ){
					$pay_order_mapping[ $_order_item_info['pay_order_id'] ] = [];
				}

				$pay_order_mapping[ $_order_item_info['pay_order_id'] ][] = [
					'title' => $tmp_soft_info['title'],
					'target_id' => $tmp_soft_info['id'],
					'quantity' => $_order_item_info['quantity']
				];
			}

			foreach( $list as $_item ){
				$data[] = [
					'id' => $_item['id'],
					'order_sn' => $_item['order_sn'],
					'pay_price' => $_item['pay_price'],
					'status_desc' => Constant::$pay_status_mapping[ $_item['status'] ],
					'status' => $_item['status'],
					'pay_time' => date("Y-m-d H:i",strtotime( $_item['pay_time'] ) ),
					'created_time' => date("Y-m-d H:i",strtotime( $_item['created_time'] ) ),
					'items' => isset( $pay_order_mapping[ $_item['id'] ] )?$pay_order_mapping[ $_item['id'] ]:[]
				];
			}
		}

    	return $this->render("my",[
			"pages" => $pages,
			'list' => $data,
			'search_conditions' => [
				'p' => $p
			]
		]);
	}
}
