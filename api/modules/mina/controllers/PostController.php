<?php

namespace api\modules\mina\controllers;

use api\modules\mina\controllers\common\BaseMinaController;
use common\models\posts\Posts;
use common\service\GlobalUrlService;
use common\components\UtilHelper;
use common\components\DataHelper;
use common\service\RecommendService;

class PostController extends BaseMinaController {
    public function actionIndex(){
		$p = $this->get("p",1);

		$type = intval($this->get("type", 1));
		$type = in_array($type, [1, 2, 3]) ? $type : 1;

		$offset = ($p - 1) * $this->page_size;

		$query = Posts::find()->where(['status' => 1]);

		switch ( $type ){
			case 2:
				$query->andWhere([ 'soul' => 0 ]);
				$query->orderBy( [ 'view_count' => SORT_DESC ] );
				break;
			case 3:
				$query->andWhere([ 'original' => 1, 'soul' => 0 ]);
				$query->orderBy( [ 'id' => SORT_DESC ] );
				break;
			default:
				$query->andWhere([ 'soul' => 0 ]);
				$query->orderBy( [ 'id' => SORT_DESC ] );
				break;
		}

		$list = $query->orderBy("id desc")
			->offset($offset)
			->limit($this->page_size)
			->all();
		$data  = [];

		if ($list) {
			foreach ($list as $_post) {
				$tmp_image_url = GlobalUrlService::buildStaticUrl("/images/web/blog_default_list.jpg");
				if( $_post['image_url'] ){
					$tmp_image_url = $_post['image_url'];
				}
				$tmp_pos_idx = stripos($tmp_image_url,"?");
				if( $tmp_pos_idx !== false ){
					$tmp_image_url = substr($tmp_image_url,0,$tmp_pos_idx);
				}
				$tmp_tags = explode(",", $_post['tags']);
				$data[] = [
					'title' => $_post['title'],
					'content' => UtilHelper::blog_short( str_replace("&nbsp;"," ", $_post['content'] ), 100),
					"tags" => $tmp_tags,
					'image_url' => $tmp_image_url,
					'id' => $_post['id'],
					'created_time' => date("Y-m-d",strtotime( $_post['created_time'] ) )
				];
			}
		}
		$has_more = ( count( $data ) < $this->page_size )?0:1;
		return $this->renderJSON([ 'list' => $data,'has_more' => $has_more ]);
    }

	public function actionInfo(){
		$id = intval( $this->post("id",0) );
		if( !$id ){
			return $this->renderJSON([],"指定博文不存在",-1);
		}

		$post_info = Posts::find()->where([ 'status' => 1,'id' => $id ])->one();
		if( !$post_info ){
			return $this->renderJSON([],"指定博文不存在",-1);
		}

		$tmp_tags = explode(",", $post_info['tags']);

		$content = preg_replace("/brush:(\w+);toolbar:false/","prettyprint linenums",$post_info['content']);


		$info = [
			'author' => DataHelper::getAuthorName(),
			'title' => $post_info['title'],
			'content' => $content,
			"tags" => $tmp_tags,
			'updated_time' => date("Y-m-d H:i",strtotime( $post_info['updated_time'] ) ),
		];

		$share_info = [
			'title' => $post_info['title'],
			'content' => UtilHelper::blog_short($post_info['content'],200),
			'url' => GlobalUrlService::buildWapUrl("/default/info",[ 'id' => $post_info['id'] ])
		];

		return $this->renderJSON([
			'info' => $info,
			'share_info' => $share_info,
			"recommend_blogs" => RecommendService::getRecommendBlog( $id )
		]);
	}
}
