<?php

namespace console\modules\blog\controllers;

use common\components\HttpClient;
use common\models\metaweblog\BlogSyncQueue;
use common\models\posts\Posts;
use common\service\SyncBlogService;
use console\modules\blog\Blog;


class Sync_blogController extends Blog{

    public function actionRun(){
        $sync_list = BlogSyncQueue::find()
            ->where([ 'status' => -1 ])
            ->orderBy("id asc")
            ->limit( count( SyncBlogService::$type_mapping ) )
            ->all();
        if( !$sync_list ){
            return $this->echoLog("no data need to handle");
        }

        $date_now = date("Y-m-d H:i:s");
        foreach( $sync_list as $_item ){
            sleep( 1 );
            $this->echoLog("--------queue_id:{$_item['id']}---------");
            $tmp_res = SyncBlogService::doSync( $_item['type'] ,$_item['blog_id'] );
            $_item->status = $tmp_res?1:0;
            $_item->updated_time = $date_now;
            $_item->update(0);
            if( !$tmp_res ){
                $this->echoLog( SyncBlogService::getLastErrorMsg() );
            }
        }
        return $this->echoLog(" Done ");
    }

    public function actionSegment(){
		$url = "https://segmentfault.com/api/user/login?_=bbbea0b803c3ad1628e282e7c4264c1b";
		$params = [
			'mail' => 'xxxx',
			'password' => 'xxx'
		];
		HttpClient::setHeader([
			"Referer" => "https://segmentfault.com/questions",
			"X-Requested-With" => "XMLHttpRequest",
			"Cookie" => 'PHPSESSID=web1~d43tt3l8u0ac0s0j1pofp5s7n4; activate_count=1; gr_user_id=8cb55f6d-b1fe-4185-b085-d0b09d1ca6d9; gr_session_id_5411b7ab1ae040ed9a4eb4a120a06ead=826e659c-fe00-464a-91d7-aa738cf61fda; Hm_lvt_e23800c454aa573c0ccb16b52665ac26=1476761422,1476953884,1477013677,1477013700; Hm_lpvt_e23800c454aa573c0ccb16b52665ac26=1477015207; _ga=GA1.2.1706666813.1477015208; _gat=1',
			"User-Agent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36",
			"Origin" => "https://segmentfault.com"
		]);
		$ret = HttpClient::post( $url , $params );
		var_dump( $ret) ;
	}

    public function actionInit(){
        $date_now = date("Y-m-d H:i:s");
        $posts_list = Posts::find()->where(['status' => 1])->orderBy("id asc")->all();
        foreach( $posts_list as $_item ){
            foreach( SyncBlogService::$type_mapping as $_type => $_f ){
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