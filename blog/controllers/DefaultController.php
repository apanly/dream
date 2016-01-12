<?php

namespace blog\controllers;

use blog\components\UrlService;
use blog\controllers\common\BaseController;
use common\components\DataHelper;
use common\components\UtilHelper;
use common\models\posts\Posts;
use common\models\posts\PostsRecommend;
use common\service\CacheHelperService;
use Yii;


class DefaultController extends BaseController{

    public function actionIndex(){
        $type = intval($this->get("type", 1));
        $type = in_array($type, [1, 2, 3]) ? $type : 1;

        $p = intval($this->get("p", 1));
        if (!$p) {
            $p = 1;
        }

        $data     = [];
        $pagesize = 10;
        $offset   = ($p - 1) * $pagesize;


        $query = Posts::find()->where(['status' => 1]);
        if ($type == 2) {
            $query->andWhere([">", "hot", 0]);
        }

        if ($type == 3) {
            $query->andWhere(['original' => 1]);
        }

        $total_count = $query->count();

        $posts_info = $query->orderBy("id desc")
            ->offset($offset)
            ->limit($pagesize)
            ->all();

        if ($posts_info) {
            $idx    = 1;
            $author = Yii::$app->params['author'];
            foreach ($posts_info as $_post) {
                $tmp_content = UtilHelper::blog_summary($_post['content'], 105);
                $tags        = explode(",", $_post['tags']);
                $data[]      = [
                    'idx'      => $idx,
                    'id'       => $_post['id'],
                    'title'    => DataHelper::encode($_post['title']),
                    'content'  => nl2br($tmp_content),
                    'original' => $_post['original'],
                    'author'   => $author,
                    'tags'     => $tags,
                    'date'     => date("Y年m月d日", strtotime($_post['updated_time'])),
                    'view_url' => UrlService::buildUrl( "/default/info" ,[ "id" => $_post['id'] ] ),
                ];
            }
        }

        $page_info = DataHelper::ipagination([
            "total_count" => $total_count,
            "pagesize"    => $pagesize,
            "page"        => $p,
            "display"     => 5
        ]);


        $tags = CacheHelperService::getFrontCache("tag");

        return $this->render("index", [
            "data"      => $data,
            "page_info" => $page_info,
            "type"      => $type,
            "hot_kws"   => array_slice($tags,0,5)
        ]);

    }

    public function actionInfo($id){

        $id = intval($id);
        if (!$id) {
            return $this->goHome();
        }
        $post_info = Posts::findOne(['id' => $id, 'status' => 1]);

        if (!$post_info) {
            return $this->goHome();
        }


        $domain_blog = Yii::$app->params['domains']['blog'];
        $author      = Yii::$app->params['author'];
        $tags        = explode(",", $post_info['tags']);
        $data        = [
            "id"       => $post_info['id'],
            "title"    => $post_info['title'],
            "content"  => $post_info['content'],
            "original" => $post_info['original'],
            "tags"     => $tags,
            'date'     => date("Y年m月d日", strtotime($post_info['updated_time'])),
            'author'   => $author,
            "url"      => UrlService::buildUrl("/default/info", [ "id" => $post_info['id'] ])
        ];

        $prev_info = Posts::find()
            ->where(["<", "id", $id])
            ->andWhere(['status' => 1])
            ->orderBy("id desc")
            ->one();

        $next_info = Posts::find()
            ->where([">", "id", $id])
            ->andWhere(['status' => 1])
            ->orderBy("id asc")
            ->one();

        //推荐相关
        $relation_blog_ids = PostsRecommend::find()
            ->select("relation_blog_id")
            ->where(['blog_id' => $id])
            ->orderBy("score desc")
            ->limit(5)
            ->asArray()
            ->column();

        $recommend_blogs = [];
        if( $relation_blog_ids ){
            $relation_post_list = Posts::findAll(['id' => $relation_blog_ids, 'status' => 1]);
            if( $relation_post_list ){
                foreach( $relation_post_list as $_relation_blog_info ){
                    $recommend_blogs[] = [
                        "title" => DataHelper::encode( $_relation_blog_info['title'] ),
                        'view_url' => UrlService::buildUrl("/default/info",[ "id" => $_relation_blog_info['id'],"flag" =>"recommend" ]),
                    ];
                }
            }
        }




        $this->setTitle($post_info['title'] . " - 郭大帅哥的博客");
        $this->setDescription($post_info['title'] . " - 郭大帅哥的博客");
        $this->setKeywords($post_info['tags'] . " - 郭大帅哥的博客");

        return $this->render("detail", [
            "info"      => $data,
            "prev_info" => $prev_info,
            "next_info" => $next_info,
            "recommend_blogs" => $recommend_blogs
        ]);
    }

    public function actionAbout()
    {
        $this->setTitle("郭大帅哥的简介");
        return $this->render("about");
    }

    public function actionDonation()
    {
        $this->setTitle("赞助 -- 有钱任性");
        return $this->render("donation");
    }

}