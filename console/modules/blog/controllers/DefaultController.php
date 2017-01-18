<?php

namespace console\modules\blog\controllers;

use common\models\applog\AdCspReport;
use common\models\posts\Posts;
use common\service\SyncBlogService;
use console\modules\blog\Blog;


class DefaultController extends Blog{
    public function actionIndex(){
    }

    /*
     * php yii  blog/default/change-domain
     */
    public function actionChangeDomain(){
    	$list = Posts::find()->orderBy([ 'id' => SORT_ASC ])->all();
    	foreach( $list as $_item ){
    		$tmp_content = $_item['content'];
    		$tmp_content = str_replace("www.vincentguo.cn","www.54php.cn",$tmp_content);
    		$tmp_content = str_replace("cdn.pic1.yunetidc.com","cdn.pic1.54php.cn",$tmp_content);
			preg_match('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$tmp_content,$match_img);
			if( $match_img && count($match_img) == 3 ){
				$_item->image_url = $match_img[2];
			}else{
				$_item->image_url = "";
			}
			$_item->content = $tmp_content;
			$_item->update( 0 );
		}
	}
}