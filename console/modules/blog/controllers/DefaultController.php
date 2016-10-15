<?php

namespace console\modules\blog\controllers;

use common\models\applog\AccessLogs;
use common\models\posts\Posts;
use console\modules\blog\Blog;
use common\service\health\HealthService;

class DefaultController extends Blog{
    public function actionIndex(){

    }

    public function actionFixAccessLog(){
    	$stat_list = AccessLogs::find()
			->select([ 'blog_id','count(*) as counter' ])
			->where([ '>','blog_id',0 ])
			->groupBy("blog_id")
			->asArray()
			->all();
		foreach( $stat_list as $_item ){
			if( $_item['blog_id'] < 0 ){
				continue;
			}
			$this->echoLog( $_item['blog_id'].":".$_item['counter'] );
			$blog_info = Posts::findOne([ 'id' => $_item['blog_id'] ]);
			if( $blog_info ){
				$blog_info->view_count =  $_item['counter'];
				$blog_info->update(0);
			}
		}
	}
}