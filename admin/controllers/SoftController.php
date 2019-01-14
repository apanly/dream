<?php

namespace admin\controllers;


use admin\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\pay\PayOrder;
use common\models\pay\PayOrderItem;
use common\models\soft\Soft;
use common\service\Constant;
use common\service\PayOrderService;
use Yii;
use yii\helpers\Url;

class SoftController extends BaseController{
	public function actionIndex(){
		$p  = intval($this->get("p", 1));
		$status  = intval($this->get("status", -99));
		$order_by = $this->get("order_by", '');
		$kw   = trim($this->get("kw", ''));
		if (!$p) {
			$p = 1;
		}
		$data = [];
		$query = Soft::find();
		if ($status >= -2) {
			$query->andWhere(['status' => $status]);
		}

		if ($kw) {
			$query->andWhere(['LIKE', 'title', '%' . strtr($kw, ['%' => '\%', '_' => '\_', '\\' => '\\\\']) . '%', false]);
		}

		$total_count = $query->count();

		if ($order_by) {
			$query->orderBy([$order_by => $this->get($order_by) ? SORT_DESC : SORT_ASC]);
		} else {
			$query->orderBy(['id' => SORT_DESC]);
		}


		$offset    = ($p - 1) * $this->page_size;
		$soft_list = $query->offset($offset)
			->limit($this->page_size)
			->asArray()
			->all();

		$page_info = DataHelper::ipagination([
			"total_count" => $total_count,
			"page_size"   => $this->page_size,
			"page"        => $p,
			"display"     => 10
		]);

		if ($soft_list) {
			$idx = 1;

			foreach ($soft_list as $_info) {
				$tmp_title = $_info['title'];
				if (mb_strlen($tmp_title, "utf-8") > 30) {
					$tmp_title = mb_substr($_info['title'], 0, 30, 'utf-8') . "...";
				}

				$data[] = [
					'idx'         => $idx,
					'id'          => $_info['id'],
					'title'       => DataHelper::encode($tmp_title),
					'status'      => $_info['status'],
					'type_desc'   => Constant::$soft_type[$_info['type']],
					'view_count'  => $_info['view_count'],
					'status_info' => Constant::$soft_status_desc[$_info['status']],
					'created'     => $_info['created_time'],
					'edit_url'    => Url::toRoute("/soft/set?id={$_info['id']}"),
				];
				$idx++;
			}
		}

		$search_conditions = [
			'kw'       => $kw,
			'status'   => $status,
			'order_by' => $order_by,
			$order_by  => $this->get($order_by)
		];

		return $this->render("index", [
			"data"              => $data,
			"page_info"         => $page_info,
			"search_conditions" => $search_conditions,
			'status_mapping'    => Constant::$soft_status_desc
		]);
	}

	public function actionSet(){
		$request = Yii::$app->request;
		if ($request->isGet) {
			$id   = trim($this->get("id", 0));
			$info = [];
			if ($id) {
				$post_info = Soft::findOne(['id' => $id]);
				if ($post_info) {
					$info = [
						"id"      => $post_info['id'],
						"title"   => DataHelper::encode($post_info['title']),
						"content" => DataHelper::encode($post_info['content']),
						"type"    => $post_info['type'],
						"down_url"    => $post_info['down_url'],
						"need_buy"    => $post_info['need_buy'],
						"price"    => $post_info['price'],
						"free_number"    => $post_info['free_number'],
						"status"  => $post_info['status'],
						"tags"    => DataHelper::encode($post_info['tags'])
					];
				}
			}
			//set or add
			return $this->render("set", [
				"info"        => $info,
				"posts_type"  => Constant::$soft_type,
				"status_desc" => Constant::$soft_status_desc
			]);
		}

		$id = trim($this->post("id", 0));
		$title   = trim($this->post("title"));
		$content = trim($this->post("content"));
		$down_url = trim( $this->post("down_url") );
		$need_buy = trim( $this->post("need_buy") );
		$price = intval( trim( $this->post("price",0) ) );
		$free_number = intval( trim( $this->post("free_number",0) ) );
		$tags    = trim($this->post("tags"));
		$type    = trim($this->post("type"));
		$status  = trim($this->post("status", 0));

		if (mb_strlen($title, "utf-8") <= 0 || mb_strlen($title, "utf-8") > 100) {
			return $this->renderJSON([], "请输入标题并且少于100个字符", -1);
		}

		if (intval($type) <= 0) {
			return $this->renderJSON([], "请选择类型", -1);
		}

		$date_now = date("Y-m-d H:i:s");
		if ($id) {
			$model_soft = Soft::findOne(['id' => $id]);
		} else {
			$model_soft = new Soft();
			$model_soft->setUniqueSn();
			$model_soft->created_time = $date_now;
		}
		$tags_arr = [];
		$tags     = explode(",", $tags);
		if ($tags) {
			foreach ($tags as $_tag) {
				if (!in_array($_tag, $tags_arr)) {
					$tags_arr[] = $_tag;
				}
			}
		}

		preg_match('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i', $content, $match_img);
		if ($match_img && count($match_img) == 3) {
			$model_soft->image_url = $match_img[2];
		} else {
			$model_soft->image_url = "";
		}

		$model_soft->title  = $title;
		$model_soft->down_url  = $down_url;
		$model_soft->need_buy  = $need_buy;
		$model_soft->price  = $price;
		$model_soft->free_number  = $free_number;
		$model_soft->content = $content;
		$model_soft->type = $type;
		$model_soft->status = $status;
		$model_soft->tags = $tags_arr ? implode(",", $tags_arr) : "";
		$model_soft->updated_time = $date_now;
		$model_soft->save(0);



		return $this->renderJSON([ 'id' => $id ], "发布成功~~");
	}

	public function actionOps($id){
		$id  = intval($id);
		$act = trim($this->post("act"));
		if (!$id) {
			return $this->renderJSON([], "操作有误，不存在的信息~~", -1);
		}
		$soft_info = Soft::findOne(["id" => $id]);

		if (!$soft_info) {
			return $this->renderJSON([], "操作有误，不存在的信息~~", -1);
		}

		switch ($act) {
			case "del":
				$soft_info->status = 0;
				break;
			case "online":
				$soft_info->status = 1;
				break;
		}

		$soft_info->updated_time = date("Y-m-d H:i:s");
		$soft_info->update(0);

		switch ($act) {
			case "del":
				//$this->afterDel( $id );
				break;
			case "online":
				//$this->afterOnline( $id );
				break;
		}

		return $this->renderJSON([], "操作成功!!");
	}

	public function actionNgrok(){
		$pay_order_id = intval( $this->get("pay_order_id",0) );
		if( !$pay_order_id ){
			return $this->renderJSON( [] ,"非法的pay_order_id",-1);
		}

		$pay_order_info = PayOrder::findOne([ 'id' => $pay_order_id,"status" => -8 ]);
		if( !$pay_order_info ){
			return $this->renderJSON( [] ,"没找到对应的支付单",-1);
		}

		$config_market = \Yii::$app->params['market'];
		$has_ngrok = PayOrderItem::find()->where([ 'pay_order_id' => $pay_order_info,'target_id' =>  $config_market['ngrok'] ])->count();
		if( !$has_ngrok ){
			return $this->renderJSON( [] ,"非ngrok支付单",-1);
		}

		$ret = PayOrderService::orderSuccess( $pay_order_info['id'] );
		$msg = "支付成功，请前去设置~~";
		if( !$ret ){
			$msg = PayOrderService::getLastErrorMsg();
		}
		return $this->renderJSON([],$msg );
	}

}