<?php

namespace admin\controllers;

use admin\components\AdminUrlService;
use admin\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\awephp\AweDocs;
use common\models\awephp\AweMenu;
use common\service\CacheHelperService;
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

		$before_status = $model_docs->status;
		$model_docs->title = $title;
		$model_docs->content = $content;
		$model_docs->status = $status;
		$model_docs->updated_time = $date_now;
		$model_docs->save(0);
		if( $before_status != $status && $status == 1 ){//说明发布了
			CacheHelperService::buildAweMenu( true );
		}

		return $this->renderJSON([ 'id' => $model_docs->id ],"操作成功");
	}


	public function actionMenu(){
		$list  = AweMenu::find()->orderBy([ 'weight' => SORT_ASC ])->asArray()->all();
		$menu_data = [];
		if( $list ){
			//先找出一级菜单
			$docs_ids = [];
			foreach( $list as $_item ){
				if(  $_item['parent_id'] == 0  ){
					$menu_data[ $_item['id'] ] = [
						'id' => $_item['id'],
						'title' => DataHelper::encode( $_item['title'] ),
						'weight' => $_item['weight'],
						'sub_menu' => []
					];
				}else{
					$docs_ids[] = $_item['doc_id'];
				}
			}
			//先找出二级菜单
			if( $docs_ids ){
				$docs_mapping = AweDocs::find()->where([ 'id' => $docs_ids ])->indexBy('id')->asArray()->all();
				foreach( $list as $_item ){
					if(  $_item['parent_id'] && isset( $docs_mapping[ $_item['doc_id'] ] )) {
						$tmp_doc_info = $docs_mapping[ $_item['doc_id'] ];
						$menu_data[ $_item['parent_id'] ]['sub_menu'][] = [
							'doc_id' => $tmp_doc_info['id'],
							'doc_title' => DataHelper::encode( $tmp_doc_info['title'] ),
							'parent_id' => $_item['parent_id'],
							'id' => $_item['id'],
							'weight' => $_item['weight']
						];
					}
				}
			}
		}
		return $this->render("menu",[
			'list' => $menu_data
		]);
	}

	public function actionMenuSet(){
		if( Yii::$app->request->isGet ){
			$id = intval( $this->get("id",0) );
			$info = [];
			if( $id ){
				$info = AweMenu::find()->where([ 'id' => $id ])->one();
			}
			$content_html = $this->renderPartial("menu_set",[
				'info' => $info
			]);
			return $this->renderJSON([ 'form_wrap' => $content_html ]);
		}

		$id = intval( $this->post("id",0) );
		$title = trim( $this->post("title","") );
		$weight = intval( $this->post("weight",0) );
		$date_now = date("Y-m-d H:i:s");

		if( !$title ){
			return $this->renderJSON([],"请输入符合规范的菜单名称~~",-1);
		}

		if( !$weight || $weight < 1 ){
			return $this->renderJSON([],"请输入符合规范的权重~~",-1);
		}

		$has_in = AweMenu::find()->where([ 'title' => $title ])->andWhere([ '!=','id',$id ])->count();
		if( $has_in ){
			return $this->renderJSON([],"此菜单名称已有啦，请换一个吧~~",-1);
		}

		$info = [];
		if( $id ){
			$info = AweMenu::find()->where([ 'id' => $id ])->one();
		}

		if( $info ){
			$model_menu = $info;
		}else{
			$model_menu = new AweMenu();
			$model_menu->created_time = $date_now;
		}
		$model_menu->title = $title;
		$model_menu->weight = $weight;
		$model_menu->updated_time = $date_now;
		$model_menu->save( 0 );
		return $this->renderJSON([],"操作成功~~");
	}

	public function actionMenuSubSet(){
		if( Yii::$app->request->isGet ){
			$id = intval( $this->get("id",0) );
			$parent_id = intval( $this->get("parent_id",0) );
			$parent_info = AweMenu::find()->where([ 'id' => $parent_id ])->one();
			if( !$parent_info ){
				return $this->renderJSON([],"指定父菜单不存在~~",-1);
			}
			$info = [];
			if( $id ){
				$info = AweMenu::find()->where([ 'id' => $id ])->one();
			}

			$related_docs_ids = AweMenu::find()
				->where([ '>','doc_id',0 ])
				->andWhere([ '!=','id',$id ])
				->select([ 'doc_id' ])->column();

			$docs_list = AweDocs::find()->where([ 'not in','id', $related_docs_ids ])
				->orderBy([ 'id' => SORT_DESC ])->asArray()->all();
			$content_html = $this->renderPartial("menu_sub_set",[
				'parent_info' => $parent_info,
				'docs_list' => $docs_list,
				'info' => $info
			]);
			return $this->renderJSON([ 'form_wrap' => $content_html ]);
		}

		$id = intval( $this->post("id",0) );
		$parent_id = intval( $this->post("parent_id",0) );
		$doc_id = intval( $this->post("doc_id",0) );
		$weight = intval( $this->post("weight",0) );
		$date_now = date("Y-m-d H:i:s");

		$parent_info = AweMenu::find()->where([ 'id' => $parent_id ])->one();
		if( !$parent_info ){
			return $this->renderJSON([],"指定父菜单不存在~~",-1);
		}

		$doc_info = AweDocs::find()->where([ 'id' => $doc_id ])->one();
		if( !$doc_info ){
			return $this->renderJSON([],"关联教程不存在~~",-1);
		}

		$has_bind = AweMenu::find()->where([ 'doc_id' => $doc_id ])->andWhere([ '!=' ,'parent_id', $parent_id ])->count();
		if( $has_bind ){
			return $this->renderJSON([],"指定教程已和其他菜单绑定~~",-1);
		}

		$info = [];
		if( $id ){
			$info = AweMenu::find()->where([ 'id' => $id ])->one();
		}

		if( $info ){
			$model_menu = $info;
		}else{
			$model_menu = new AweMenu();
			$model_menu->created_time = $date_now;
		}
		$model_menu->weight = $weight;
		$model_menu->doc_id = $doc_id;
		$model_menu->parent_id = $parent_id;
		$model_menu->updated_time = $date_now;
		$model_menu->save( 0 );
		return $this->renderJSON([],"操作成功~~");
	}

	public function actionMenuRefresh(){
		CacheHelperService::buildAweMenu( true );
		return $this->renderJSON([],"更新成功~~");
	}
}

