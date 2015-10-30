<?php

namespace blog\controllers;

use blog\controllers\common\BaseController;
use common\models\posts\Posts;
use common\models\posts\PostsTags;
use Yii;


class PublicController extends BaseController
{
    public function actionTags()
    {
        $ret  = [];
        $tags = PostsTags::find()
            ->select("tag,count(*) as num ")
            ->groupBy("tag")
            ->orderBy("num desc , posts_id desc")
            ->limit(20)
            ->all();

        if ($tags) {
            foreach ($tags as $_tag) {
                $ret[] = $_tag['tag'];
            }
        }
        return $this->renderJSON($ret);
    }

    public function actionBlogs()
    {
        $ret = [
            "hots" => [],
            "news" => []
        ];

        $hots = Posts::find()
            ->where(['status' => 1])
            ->orderBy("updated_time desc")
            ->limit(3)
            ->all();

        $news = Posts::find()
            ->where(['status' => 1])
            ->orderBy("id desc")
            ->limit(3)
            ->all();

        if ($hots) {
            foreach ($hots as $_hot) {
                $ret['hots'][] = [
                    "id"    => $_hot['id'],
                    "title" => $_hot['title'],
                    "url"   => "/default/{$_hot['id']}"
                ];
            }
        }

        if ($news) {
            foreach ($news as $_new) {
                $ret['news'][] = [
                    "id"    => $_new['id'],
                    "title" => $_new['title'],
                    "url"   => "/default/{$_new['id']}"
                ];
            }
        }

        return $this->renderJSON($ret);
    }
}