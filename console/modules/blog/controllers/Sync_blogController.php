<?php

namespace console\modules\blog\controllers;

use common\models\metaweblog\BlogSyncQueue;
use common\models\posts\Posts;
use common\service\SyncBlogServince;
use console\modules\blog\Blog;


class Sync_blogController extends Blog{

    public function actionRun(){
        $sync_list = BlogSyncQueue::find()
            ->where([ 'status' => -1 ])
            ->orderBy("id asc")
            ->limit( 10 )
            ->all();
        if( !$sync_list ){
            return $this->echoLog("no data need to handle");
        }

        $date_now = date("Y-m-d H:i:s");
        foreach( $sync_list as $_item ){
            $this->echoLog("--------queue_id:{$_item['id']}---------");
            $tmp_res = SyncBlogServince::doSync( $_item['type'] ,$_item['blog_id'] );
            $_item->status = $tmp_res?1:0;
            $_item->updated_time = $date_now;
            $_item->update(0);
        }
        return $this->echoLog(" Done ");
    }

    public function actionInit(){
        $date_now = date("Y-m-d H:i:s");
        $posts_list = Posts::find()->where(['status' => 1])->orderBy("id asc")->all();
        foreach( $posts_list as $_item ){
            foreach( SyncBlogServince::$type_mapping as $_type => $_f ){
                $model_blog_sync_queue = new BlogSyncQueue();
                $model_blog_sync_queue->blog_id = $_item['id'];
                $model_blog_sync_queue->type = $_type;
                $model_blog_sync_queue->updated_time = $date_now;
                $model_blog_sync_queue->created_time = $date_now;
                $model_blog_sync_queue->status = -1;
                $model_blog_sync_queue->save(0);
            }
        }
    }
}