<?php

namespace api\controllers;

use common\components\UtilHelper;

use common\models\posts\Posts;
use common\service\GlobalUrlService;
use Yii;
use api\controllers\common\AuthController;

class DefaultController extends AuthController{
    public function actionIndex(){
        return "Hi Guest,IP:".UtilHelper::getClientIP().",Time:".date('Y-m-d H:i:s');
    }

    public function actionBanner(){
        $list = Posts::find()
            ->where([ 'original' => 1 ])
            ->orderBy([ "id" => SORT_DESC ])
            ->limit(5)
            ->all();

        $ret = [];
        if( $list ){
            foreach( $list as $_info ){
                $tmp_image_url = GlobalUrlService::buildStaticUrl("/images/web/blog_default.jpg");
                if( $_info['image_url'] ){
                    $tmp_image_url = $_info['image_url'];
                }
                $tmp_pos_idx = stripos($tmp_image_url,"?");
                if( $tmp_pos_idx !== false ){
                    $tmp_image_url = substr($tmp_image_url,0,$tmp_pos_idx);
                }
                $ret[] = [
                    'title' => $_info['title'],
                    'id' => $_info['id'],
                    'type' => 'blog',
                    'image_url' => $tmp_image_url
                ];
            }
        }
        return $this->renderJSON([ 'list' => $ret ]);
    }

    public function actionBlog(){
        $p = $this->get("p",1);
    }
}