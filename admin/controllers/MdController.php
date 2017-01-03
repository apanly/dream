<?php

namespace admin\controllers;

use admin\components\AdminUrlService;
use admin\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\awephp\AweDocs;
use common\service\Constant;
use Yii;

class MdController extends BaseController{
	public function actionIndex(){
		$p = intval( $this->get("p",1) );
		$status = intval( $this->get("status",-99) );
		$order_by = $this->get("order_by",'');
		$kw = trim( $this->get("kw",'') );
		if(!$p){
			$p = 1;
		}


		$query = AweDocs::find();
		if( $status >= -2 ){
			$query->andWhere([ 'status' => $status ]);
		}

		if( $kw ){
			$query->andWhere( ['LIKE', 'title', '%' . strtr($kw, ['%' => '\%', '_' => '\_', '\\' => '\\\\']) . '%', false] );
		}

		$total_count = $query->count();

		if( $order_by ){
			$query->orderBy([ $order_by => $this->get( $order_by )?SORT_DESC:SORT_ASC ]);
		}else{
			$query->orderBy([ 'id' => SORT_DESC ]);
		}


		$offset = ($p - 1) * $this->page_size;
		$list = $query->offset($offset)
			->limit( $this->page_size )
			->asArray()
			->all();

		$page_info = DataHelper::ipagination([
			"total_count" => $total_count,
			"page_size" => $this->page_size,
			"page" => $p,
			"display" => 10
		]);

		$data = [];
		if( $list ){
			foreach( $list as $_item){
				$tmp_title = $_item['title'];
				if(mb_strlen($tmp_title,"utf-8") > 30){
					$tmp_title = mb_substr($tmp_title,0,30,'utf-8')."...";
				}

				$data[] = [
					'id' => $_item['id'],
					'title' => DataHelper::encode($tmp_title),
					'status' => $_item['status'],
					'status_info' => Constant::$status_desc[ $_item['status'] ],
					'created' => $_item['created_time'],
					'edit_url' => AdminUrlService::buildUrl("/md/set",[ 'id' => $_item['id'] ])
				];
			}
		}

		$search_conditions = [
			'kw' => $kw,
			'status' => $status,
			'order_by' => $order_by,
			$order_by => $this->get($order_by)
		];

		return $this->render("index",[
			"data" => $data,
			"page_info" => $page_info,
			"search_conditions" => $search_conditions,
			'status_mapping' => Constant::$status_desc
		]);
	}

	public function actionSet(){
		if( Yii::$app->request->isGet ){
			$id = intval( $this->get("id",0) );
			$info = [];
			if($id){
				$docs_info = AweDocs::findOne([ 'id' => $id ]);
				if( $docs_info ){
					$info = [
						"id" => $docs_info['id'],
						"title" => DataHelper::encode( $docs_info['title'] ),
						"content" => DataHelper::encode( $docs_info['content'] ),
						"status" => $docs_info['status']
					];
				}
			}

			return $this->render("set",[
				"info" => $info,
				"status_desc" => Constant::$status_desc,
			]);
		}

		$uid = $this->current_user->uid;
		$id =trim( $this->post("id",0) );
		$title =trim( $this->post("title") );
		$content = trim( $this->post("content") );
		$status = trim($this->post("status",0));

		if( mb_strlen($title,"utf-8") <= 0 || mb_strlen($title,"utf-8") > 100 ){
			return $this->renderJSON([],"请输入博文标题并且少于100个字符",-1);
		}

		if( mb_strlen($content,"utf-8") <= 0 ){
			return $this->renderJSON([],"请输入更多点博文内容",-1);
		}

		$date_now = date("Y-m-d H:i:s");
		if($id){
			$model_docs = AweDocs::findOne([ 'id' => $id ]);
		}else{
			$model_docs = new AweDocs();
			$model_docs->created_time = $date_now;
		}

		$model_docs->title = $title;
		$model_docs->content = $content;
		$model_docs->status = $status;
		$model_docs->updated_time = $date_now;
		$model_docs->save(0);
		return $this->renderJSON([ 'id' => $model_docs->id ],"操作成功");
	}
}

