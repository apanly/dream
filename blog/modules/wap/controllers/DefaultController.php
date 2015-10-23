<?php

namespace blog\modules\wap\controllers;
use blog\components\UrlService;
use blog\modules\wap\controllers\common\BaseController;
use common\components\DataHelper;
use common\components\UtilHelper;
use common\models\posts\Posts;
use Yii;
use yii\helpers\Url;

class DefaultController extends BaseController{
    public function actionIndex(){
        $data = [];
        $pagesize = 5;
        $offset = 0;
        $query = Posts::find()->where(['status' => 1]);
        $posts_info = $query->orderBy("id desc")
            ->offset($offset)
            ->limit($pagesize)
            ->all();

        if($posts_info){
            foreach($posts_info as $_post){
                $data[] = [
                    'title' => DataHelper::encode($_post['title']),
                    'content' => nl2br( UtilHelper::blog_short($_post['content'],200) ),
                    'image_url' => $_post['image_url'],
                    'view_url' => UrlService::buildWapUrl("/default/info",["id" => $_post['id'] ]),
                ];
            }
        }

        return $this->render("index",[
            "post_list" => $data
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

        $this->setTitle( $post_info['title']." - 郭大帅哥的博客");
        $tags = explode(",",$post_info['tags']);
        $author = Yii::$app->params['author'];
        $data = [
            "title" => $post_info['title'],
            "content" => $post_info['content'],
            "tags" => $tags,
            "author" => $author,
            'date' => date("Y年m月d日",strtotime($post_info['updated_time']))
        ];

        return $this->render("info",[
            "info" => $data
        ]);
    }
}