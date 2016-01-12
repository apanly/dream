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
            ->limit( 6 )
            ->all();
        if( !$sync_list ){
            return $this->echoLog("no data need to handle");
        }

        $date_now = date("Y-m-d H:i:s");
        foreach( $sync_list as $_item ){
            sleep( 1 );
            $this->echoLog("--------queue_id:{$_item['id']}---------");
            $tmp_res = SyncBlogServince::doSync( $_item['type'] ,$_item['blog_id'] );
            $_item->status = $tmp_res?1:0;
            $_item->updated_time = $date_now;
            $_item->update(0);
            if( !$tmp_res ){
                $this->echoLog( SyncBlogServince::getLastErrorMsg() );
            }
        }
        return $this->echoLog(" Done ");
    }
}