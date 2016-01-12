<?php
namespace console\modules\blog\controllers;

use common\models\posts\Posts;
use common\models\posts\PostsRecommendQueue;
use common\service\RecommendService;
use console\modules\blog\Blog;
class RecommendController extends Blog{

    public function actionQueue(){
        $posts_queue_list = PostsRecommendQueue::find()
            ->where([ 'status' => -1 ])
            ->orderBy("id asc")
            ->limit(6)
            ->all();
        if( !$posts_queue_list ){
            return $this->echoLog("no data need to handle");
        }

        $date_now = date("Y-m-d H:i:s");
        foreach( $posts_queue_list as $_item ){
            sleep( 1 );
            $this->echoLog("--------queue_id:{$_item['id']}---------");
            $tmp_ret = RecommendService::calculateRecommend( $_item['blog_id'] );
            $_item->status = $tmp_ret?1:0;
            $_item->updated_time = $date_now;
            $_item->update(0);
        }
        return $this->echoLog(" Done ");
    }

    public function actionDaily(){
        $post_list = Posts::findAll(['status' => 1]);
        foreach( $post_list as $_post_info ){
            RecommendService::calculateRecommend( $_post_info['id'] );
        }
    }
} 