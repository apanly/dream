<?php

namespace console\modules\blog\controllers;

use common\models\applog\AccessLogs;
use console\modules\blog\Blog;
use common\service\health\HealthService;

class DefaultController extends Blog{
    public function actionIndex(){

    }

    public function actionFixAccessLog(){
    	$list = AccessLogs::find()->orderBy([ 'id' => SORT_ASC ])->all();
		foreach( $list as $_item){
			$tmp_blog_id = 0;
			preg_match("/\/default\/(\d+)(.html)?/",$_item['target_url'],$matches);
			if( $matches && count( $matches ) >= 2  ){
				$tmp_blog_id = $matches[1];
			}

			if( $_item['referer'] ){
				$tmp_source = parse_url( $_item['referer'] ,PHP_URL_HOST );
				$_item->source = $tmp_source;
			}
			$_item->blog_id = $tmp_blog_id;
			$_item->update(0);
		}
	}
}