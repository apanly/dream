<?php

namespace blog\controllers;

use blog\controllers\common\BaseController;
use common\components\DataHelper;
use common\components\UtilHelper;
use common\models\posts\Posts;
use Yii;
use yii\helpers\Url;


class DefaultController extends BaseController
{
    public function actionIndex(){
        $p = intval($this->get("p",1));
        if(!$p){
            $p = 1;
        }

        $data = [];
        $pagesize = 10;
        $offset = ($p -1 ) * $pagesize;


        $query = Posts::find()->where(['status' => 1]);
        $total_count = $query->count();

        $posts_info = $query->orderBy("id desc")
            ->offset($offset)
            ->limit($pagesize)
            ->all();

        if($posts_info){
            $idx = 1;
            $author = Yii::$app->params['author'];
            foreach($posts_info as $_post){
                $tmp_content = UtilHelper::blog_summary($_post['content'],105);
                $tags = explode(",",$_post['tags']);
                $data[] = [
                    'idx' =>  $idx,
                    'id' => $_post['id'],
                    'title' => DataHelper::encode($_post['title']),
                    'content' => nl2br( $tmp_content ),
                    'original' => $_post['original'],
                    'author' => $author,
                    'tags' => $tags,
                    'date' => date("Y年m月d日",strtotime($_post['updated_time'])),
                    //'view_url' => Url::toRoute("/default/{$_post['id']}"),
                    'view_url' => Url::toRoute(["/default/info","id" => $_post['id'] ]),
                ];
            }
        }

        $page_info = DataHelper::ipagination([
            "total_count" => $total_count,
            "pagesize" => $pagesize,
            "page" => $p,
            "display" => 5
        ]);

        return $this->render("index",[
            "data" => $data,
            "page_info" => $page_info
        ]);
    }

    public function actionInfo($id){
        $id = intval($id);
        if(!$id){
            return $this->goHome();
        }
        $post_info = Posts::findOne(['id' => $id,'status' => 1]);

        if(!$post_info){
            return $this->goHome();
        }



        $author = Yii::$app->params['author'];
        $tags = explode(",",$post_info['tags']);
        $data = [
            "title" => $post_info['title'],
            "content" => $post_info['content'],
            "original" => $post_info['original'],
            "tags" => $tags,
            'date' => date("Y年m月d日",strtotime($post_info['updated_time'])),
            'author' => $author
        ];

        $prev_info = Posts::find()
            ->where(["<","id",$id])
            ->andWhere(['status' => 1])
            ->orderBy("id desc")
            ->one();
        $next_info = Posts::find()
            ->where([">","id",$id])
            ->andWhere(['status' => 1])
            ->orderBy("id asc")
            ->one();

        $this->setTitle( $post_info['title']." - 郭大帅哥的博客");
        $this->setDescription($post_info['title']." - 郭大帅哥的博客" );
        $this->setKeywords($post_info['tags']." - 郭大帅哥的博客");

        return $this->render("detail",[
            "info" => $data,
            "prev_info" => $prev_info,
            "next_info" => $next_info
        ]);
    }

    public function actionAbout(){
        $this->setTitle("郭大帅哥的简介");
        return $this->render("about");
    }

    public function actionDonation(){
        $this->setTitle("赞助 -- 有钱任性");
        return $this->render("donation");
    }

}