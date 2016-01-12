<?php
namespace console\modules\blog\controllers;

use common\models\posts\Posts;
use common\service\RecommendService;
use console\modules\blog\Blog;
class RecommendController extends Blog{

    public function actionRun(){
        $post_list = Posts::findAll(['status' => 1]);
        foreach( $post_list as $_post_info ){
            RecommendService::calculateRecommend( $_post_info['id'] );
        }
    }
} 