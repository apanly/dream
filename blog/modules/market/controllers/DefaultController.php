<?php

namespace blog\modules\market\controllers;

use blog\modules\market\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\soft\Soft;
use common\service\Constant;
use common\service\GlobalUrlService;

/**
 * http://www.shafa.com/ 模板
 */

class DefaultController extends BaseController {

    public function actionIndex(){

    	$mina_list = Soft::find()->where([ 'type' => 1,'status' => 1 ])
			->orderBy([ 'id' => SORT_DESC ])->limit( 4 )->all();

		$site_list = Soft::find()->where([ 'type' => 3,'status' => 1 ])
			->orderBy([ 'id' => SORT_DESC ])->limit( 4 )->all();

        return $this->render('index',[
        	'mina_list' => $mina_list,
        	'site_list' => $site_list,
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

		$this->setTitle( DataHelper::encode( $info['title'] ) );

    	return $this->render( "info",[
    		'info' => $info
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
					'image_url' => $_item['image_url'],
					'author' => $author,
					'tags'  => $tags,
					'type_desc'  => Constant::$soft_type[ $_item['type'] ],
					'date'  => date("Y.m.d", strtotime( $_item['updated_time'] ) ),
					'view_url' => GlobalUrlService::buildSuperMarketUrl( "/default/info" ,[ "id" => $_item['id'] ] ),
				];
			}
		}

		$page_info = DataHelper::ipagination([
			"total_count" => $total_count,
			"page_size"    => $pagesize,
			"page"        => $p,
			"display"     => 5
		]);

		return $this->render( "mina",[
			"data"      => $data,
			"page_info" => $page_info,
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

		$page_info = DataHelper::ipagination([
			"total_count" => $total_count,
			"page_size"    => $pagesize,
			"page"        => $p,
			"display"     => 5
		]);

		return $this->render( "site",[
			"data"      => $data,
			"page_info" => $page_info,
		] );
	}
}
