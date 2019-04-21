<?php

namespace blog\controllers;

use blog\controllers\common\BaseController;
use common\components\DataHelper;
use common\components\UtilHelper;
use common\models\posts\Posts;
use common\models\search\IndexSearch;
use common\service\GlobalUrlService;
use Yii;

/**
 * V3版本首页，V3版本打造社区首页
 * 参考：http://v.bootstrapmb.com/2019/3/ik0la3804/
 */
class IndexController extends BaseController{

	public function __construct($id, $module, $config = []){
		parent::__construct($id, $module, $config = []);
		$this->layout = "main_v3";
	}

    public function actionIndex(){
		$banner_list = Posts::find()->where([ 'status' => 1 ])
			->andWhere([ "!=",'image_url',"" ])
			->orderBy( [ 'view_count' => SORT_DESC ] )
			->limit(5 )
			->all();
		$banner_data = [];
		if( $banner_list ){
			foreach ( $banner_list as $_item ){
				$banner_data[]      = [
					'image_url' => $_item['image_url'],
					'title'  => DataHelper::encode( $_item['title'] ),
					'view_url' => GlobalUrlService::buildBlogUrl( "/default/info" ,[ "id" => $_item['id'] ] ),
				];
			}
		}

		$last_blog_list = Posts::find()->where([ 'status' => 1  ])
			->andWhere([ "!=",'image_url',"" ])
			->orderBy([ 'id' => SORT_DESC ])
			->limit(10)->all();

		$data_blog_list = [];
		$author = Yii::$app->params['author'];
		if( $last_blog_list ){
			foreach ( $last_blog_list as $_item ){
				$tmp_tags = explode(",", $_item['tags']);
				$data_blog_list[]  = [
					'id' => $_item['id'],
					'title'  => DataHelper::encode( $_item['title'] ),
					'content' => mb_substr( strip_tags( $_item['content'] ),0,250),
					'original' => $_item['original'],
					'view_count' => $_item['view_count'],
					'author' => $author,
					'tags'  => $tmp_tags,
					'image_url' => $_item['image_url'],
					'date'  => date("Y.m.d", strtotime( $_item['created_time'] ) ),
					'view_url' => GlobalUrlService::buildBlogUrl( "/default/info" ,[ "id" => $_item['id'] ] ),
					'from' => "blog"
				];
			}
		}

		$hot_blog_list = Posts::find()->where([ 'status' => 1 ])
			->orderBy( [ 'view_count' => SORT_DESC ] )
			->limit(10 )
			->all();
		$hot_blog_data = [];
		if( $hot_blog_list ){
			foreach ( $hot_blog_list as $_item ){
				$hot_blog_data[] = [
					'title'  => DataHelper::encode( $_item['title'] ),
					'view_url' => GlobalUrlService::buildBlogUrl( "/default/info" ,[ "id" => $_item['id'] ] ),
				];
			}
		}

        return $this->render("index",[
        	"banner_list" => $banner_data,
			"blog_list" => $data_blog_list,
			"hot_blog_list" => $hot_blog_data,
			"project_list" => \blog\components\BlogUtilService::getProjectList(),
			"author" => $author
		] );
    }

}