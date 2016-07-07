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

    private $page_size = 10;
    public function actionBlog(){
        $p = $this->get("p",1);
        $offset = ($p - 1) * $this->page_size;

        $query = Posts::find()->where(['status' => 1]);
        $posts_info = $query->orderBy("id desc")
            ->offset($offset)
            ->limit($this->page_size)
            ->all();
        $data  = [];

        if ($posts_info) {
            foreach ($posts_info as $_post) {
                $tmp_image_url = GlobalUrlService::buildStaticUrl("/images/web/blog_default_list.jpg");
                if( $_post['image_url'] ){
                    $tmp_image_url = $_post['image_url'];
                }
                $tmp_tags = explode(",", $_post['tags']);
                $data[] = [
                    'title' => $_post['title'],
                    'content' => UtilHelper::blog_short($_post['content'], 100),
                    "tags" => $tmp_tags,
                    'image_url' => $tmp_image_url,
                    'id' => $_post['id'],
                ];
            }
        }

        return $this->renderJSON([ 'list' => $data ]);
    }
}