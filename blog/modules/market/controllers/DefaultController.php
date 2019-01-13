<?php

namespace blog\modules\market\controllers;

use blog\modules\market\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\soft\Soft;
use common\models\soft\SoftSaleChangeLog;
use common\service\Constant;
use common\service\GlobalUrlService;

/**
 * http://www.shafa.com/ 模板
 */

class DefaultController extends BaseController {

    public function actionIndex(){

		$query = Soft::find()->where([ 'type' => [ 2,3,4 ],'status' => 1]);
		$query->orderBy( [ 'id' => SORT_DESC ] );
		$list = $query->limit( 15  )->all();
		$data     = [];
		if ($list) {
			$author = \Yii::$app->params['author'];
			foreach ( $list as $_item ) {
				$tags = explode(",", $_item['tags']);
				$data[]      = [
					'id' => $_item['id'],
					'title'  => DataHelper::encode($_item['title']),
					'content'  => mb_substr( strip_tags($_item['content']) ,0,200,"utf-8"),
					'image_url' => $_item['image_url'],
					'author' => $author,
					'tags'  => $tags,
					'type_desc'  => Constant::$soft_type[ $_item['type'] ],
					'date'  => date("Y.m.d", strtotime( $_item['updated_time'] ) ),
					'view_url' => GlobalUrlService::buildSuperMarketUrl( "/default/info" ,[ "id" => $_item['id'] ] ),
				];
			}
		}

        return $this->render('index',[
			"data" => $data
		]);
    }

    public function actionInfo(){
    	$id = intval( $this->get( "id",0 ) );
    	if( $id < 1 ){
    		return $this->redirect( GlobalUrlService::buildSuperMarketUrl("/") );
		}

		$info = Soft::findOne( [ 'id' => $id,'status' => 1 ] );
    	if( !$info ){
			return $this->redirect( GlobalUrlService::buildSuperMarketUrl("/") );
		}

		$has_buy = false;
		if( $this->current_member ){
			$has_buy = SoftSaleChangeLog::findOne([ "member_id" => $this->current_member['id'],"soft_id" => $id ]);
		}

		$this->setTitle( DataHelper::encode( $info['title'] ) );

    	return $this->render( "info",[
    		'info' => $info,
			'has_buy' => $has_buy
		] );
	}

	public function actionMina(){
		$p = intval($this->get("p", 1));
		if (!$p) {
			$p = 1;
		}
		$data     = [];
		$pagesize = 10;
		$offset   = ($p - 1) * $pagesize;

		$query = Soft::find()->where([ 'type' => 1,'status' => 1]);
		$query->orderBy( [ 'updated_time' => SORT_DESC ] );
		$total_count = $query->count();
		$list = $query->offset($offset)->limit($pagesize)->all();

		if ($list) {
			$author = \Yii::$app->params['author'];
			foreach ( $list as $_item ) {
				$tags = explode(",", $_item['tags']);
				$data[]      = [
					'id' => $_item['id'],
					'title'  => DataHelper::encode($_item['title']),
					'image_url' => $_item['image_url'],
					'author' => $author,
					'tags'  => $tags,
					'type_desc'  => Constant::$soft_type[ $_item['type'] ],
					'date'  => date("Y.m.d", strtotime( $_item['updated_time'] ) ),
					'view_url' => GlobalUrlService::buildSuperMarketUrl( "/default/info" ,[ "id" => $_item['id'] ] ),
				];
			}
		}

		$pages = DataHelper::ipagination([
			"total_count" => $total_count,
			"page_size"    => $pagesize,
			"page"        => $p,
			"display"     => 5
		]);

		return $this->render( "mina",[
			"data"      => $data,
			"pages" => $pages,
		] );
	}

	public function actionSite(){
		$p = intval($this->get("p", 1));
		if (!$p) {
			$p = 1;
		}
		$data     = [];
		$pagesize = 10;
		$offset   = ($p - 1) * $pagesize;

		$query = Soft::find()->where(['type' => 3,'status' => 1]);
		$query->orderBy( [ 'id' => SORT_DESC ] );
		$total_count = $query->count();
		$list = $query->offset($offset)->limit($pagesize)->all();

		if ($list) {
			$author = \Yii::$app->params['author'];
			foreach ( $list as $_item ) {
				$tags = explode(",", $_item['tags']);
				$data[]      = [
					'id' => $_item['id'],
					'title'  => DataHelper::encode($_item['title']),
					'content'  => mb_substr( strip_tags($_item['content']) ,0,200,"utf-8"),
					'image_url' => $_item['image_url'],
					'author' => $author,
					'tags'  => $tags,
					'type_desc'  => Constant::$soft_type[ $_item['type'] ],
					'date'  => date("Y.m.d", strtotime( $_item['updated_time'] ) ),
					'view_url' => GlobalUrlService::buildSuperMarketUrl( "/default/info" ,[ "id" => $_item['id'] ] ),
				];
			}
		}

		$pages = DataHelper::ipagination([
			"total_count" => $total_count,
			"page_size"    => $pagesize,
			"page"        => $p,
			"display"     => 5
		]);

		return $this->render( "site",[
			"data"      => $data,
			"pages" => $pages,
		] );
	}

	public function actionSoft(){
		$p = intval($this->get("p", 1));
		if (!$p) {
			$p = 1;
		}
		$data     = [];
		$pagesize = 10;
		$offset   = ($p - 1) * $pagesize;

		$query = Soft::find()->where([ 'type' => 4,'status' => 1]);
		$query->orderBy( [ 'id' => SORT_DESC ] );
		$total_count = $query->count();
		$list = $query->offset($offset)->limit($pagesize)->all();

		if ($list) {
			$author = \Yii::$app->params['author'];
			foreach ( $list as $_item ) {
				$tags = explode(",", $_item['tags']);
				$data[]      = [
					'id' => $_item['id'],
					'title'  => DataHelper::encode($_item['title']),
					'content'  => mb_substr( strip_tags($_item['content']) ,0,200,"utf-8"),
					'image_url' => $_item['image_url'],
					'author' => $author,
					'tags'  => $tags,
					'type_desc'  => Constant::$soft_type[ $_item['type'] ],
					'date'  => date("Y.m.d", strtotime( $_item['updated_time'] ) ),
					'view_url' => GlobalUrlService::buildSuperMarketUrl( "/default/info" ,[ "id" => $_item['id'] ] ),
				];
			}
		}

		$pages = DataHelper::ipagination([
			"total_count" => $total_count,
			"page_size"    => $pagesize,
			"page"        => $p,
			"display"     => 5
		]);

		return $this->render( "soft",[
			"data"      => $data,
			"pages" => $pages,
		] );
	}

	public function actionAbout(){
		return $this->render("about");
	}
}
