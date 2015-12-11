<?php

namespace blog\modules\wap\controllers;

use blog\components\UrlService;
use blog\modules\wap\controllers\common\BaseController;
use common\components\DataHelper;
use common\components\UtilHelper;
use common\models\search\IndexSearch;
use Yii;

class SearchController extends BaseController{
    public function actionDo(){
        $data = [];
        $kw = $this->get("kw","");
        if( $kw ){
            $this->setTitle($kw . " - 郭大帅哥的博客");
            $search_key  = ['LIKE', 'search_key', '%' . strtr($kw, ['%' => '\%', '_' => '\_', '\\' => '\\\\']) . '%', false];
            $query       = IndexSearch::find()->where($search_key);
            $list        = $query->orderBy("id desc")->all();
            if ($list) {
                foreach ($list as $_item) {
                    if ($_item['book_id']) {
                        $tmp_title    = DataHelper::encode($_item['title']);
                        $tmp_view_url = UrlService::buildWapUrl("/library/info",['id' => $_item['book_id']]);
                    } else {
                        $tmp_title    = DataHelper::encode($_item['title']);
                        $tmp_view_url = UrlService::buildWapUrl("/default/info",['id' => $_item['post_id']]);
                    }

                    $data[] = [
                        'title'    => $tmp_title,
                        'content'  => nl2br(UtilHelper::blog_short($_item['description'], 200)),
                        'image_url' => $_item['image'],
                        'view_url' => $tmp_view_url
                    ];
                }
            }
        }




        return $this->render("do",[
            "post_list" => $data,
            'kw' => $kw
        ]);
    }
}