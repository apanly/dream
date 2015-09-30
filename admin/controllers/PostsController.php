<?php

namespace admin\controllers;

use admin\components\BlogService;
use admin\controllers\common\BaseController;
use common\components\DataHelper;
use common\components\phpanalysis\FenCiService;
use common\models\posts\Posts;
use common\models\posts\PostsTags;
use common\service\Constant;
use Yii;
use yii\helpers\Url;


class PostsController extends BaseController
{
    private $status_desc = [
        0 => ['class' => 'danger','desc' => "隐藏"],
        1 => ['class' => 'success','desc' => "正常"]
    ];
    public function actionIndex(){
        $p = intval( $this->get("p",1) );
        if(!$p){
            $p = 1;
        }

        $data = [];
        $pagesize = 20;

        $query = Posts::find();
        $total_count = $query->count();
        $offset = ($p - 1) * $pagesize;
        $posts_info = $query->orderBy("id desc")
            ->offset($offset)
            ->limit($pagesize)
            ->all();

        $page_info = DataHelper::ipagination([
            "total_count" => $total_count,
            "pagesize" => $pagesize,
            "page" => $p,
            "display" => 10
        ]);

        if($posts_info){
            $idx = 1;
            $domains = Yii::$app->params['domains'];
            foreach($posts_info as $_post){
                $tmp_title = $_post['title'];
                if(mb_strlen($tmp_title,"utf-8") > 30){
                    $tmp_title = mb_substr($_post['title'],0,30,'utf-8')."...";
                }
                $data[] = [
                    'idx' =>  $idx,
                    'id' => $_post['id'],
                    'title' => DataHelper::encode($tmp_title),
                    'status' => $_post['status'],
                    'status_info' => $this->status_desc[$_post['status']],
                    'created' => $_post['created_time'],
                    'edit_url' => Url::toRoute("/posts/add?id={$_post['id']}"),
                    'view_url' => $domains['blog'].Url::toRoute("/default/{$_post['id']}")
                ];
                $idx++;
            }
        }

        return $this->render("index",[
            "data" => $data,
            "page_info" => $page_info,
            "page_url" => "/posts/index"
        ]);
    }

    public function actionAdd(){
        $request = Yii::$app->request;
        if($request->isGet){
            $id = trim($this->get("id",0));
            $info = [];
            if($id){
                $post_info = Posts::findOne(['id' => $id]);
                if($post_info){
                    $info = [
                        "id" => $post_info['id'],
                        "title" => DataHelper::encode($post_info['title']),
                        "content" => DataHelper::encode($post_info['content']),
                        "type" => $post_info['type'],
                        "tags" => DataHelper::encode($post_info['tags'])
                    ];
                }
            }
            return $this->render("add",[
                "info" => $info,
                "posts_type" => Constant::$posts_type
            ]);
        }
        $uid = $this->current_user->uid;
        $id =trim($this->post("id",0));
        $title =trim($this->post("title"));
        $content = trim($this->post("content"));
        $tags = trim($this->post("tags"));
        $type = trim($this->post("type"));

        if( mb_strlen($title,"utf-8") <= 0 ){
            return $this->renderJSON([],"请输入博文标题",-1);
        }

        if( mb_strlen($content,"utf-8") <= 0 ){
            return $this->renderJSON([],"请输入更多点博文内容",-1);
        }

        if( mb_strlen($tags,"utf-8") <= 0 ){
            return $this->renderJSON([],"请输入博文tags",-1);
        }

        if( intval($type) <= 0){
            return $this->renderJSON([],"请选择类型",-1);
        }

        $date_now = date("Y-m-d H:i:s");
        if($id){
            $model_posts = Posts::findOne(['id' => $id]);
        }else{
            $model_posts = new Posts();
            $model_posts->uid = $uid;
            $model_posts->status = 1;
            $model_posts->created_time = $date_now;
        }
        $tags_arr = [];
        $tags = explode(",",$tags);
        if($tags){
            foreach($tags as $_tag){
                if(!in_array($_tag,$tags_arr)){
                    $tags_arr[] = $_tag;
                }
            }
        }

        $model_posts->title = $title;
        $model_posts->content = $content;
        $model_posts->type = $type;
        $model_posts->tags = $tags_arr?implode(",",$tags_arr):"";
        $model_posts->updated_time = $date_now;
        $model_posts->save(0);

        $post_id = $model_posts->id;
        BlogService::buildTags($post_id);
        return $this->renderJSON([],"博文发布成功");
    }

    public function actionGet_tags(){
        $content = trim($this->post("content"));
        $tags = FenCiService::getTags($content);
        return $this->renderJSON($tags);
    }
    public function actionOps($id){
        $id = intval($id);
        $act = trim($this->post("act","online"));
        if( !$id ){
            return $this->renderJSON([],"操作的博文可能不是你的吧!!",-1);
        }
        $post_info = Posts::findOne(["id" => $id,'uid' => $this->current_user->uid]);

        if( !$post_info ){
            return $this->renderJSON([],"操作的博文可能不是你的吧!!",-1);
        }

        if($act == "del" ){
            $post_info->status = 0;
            PostsTags::deleteAll(["posts_id" => $id]);
        }else{
            $post_info->status = 1;
            BlogService::buildTags($id);
        }

        $post_info->updated_time = date("Y-m-d H:i:s");
        $post_info->update(0);
        return $this->renderJSON([],"操作成功!!");
    }

    private function buildTags($post_id){
        $post_info = Posts::findOne(['id' => $post_id]);
        if( !$post_info ){
            return ;
        }

        $tags_arr = $post_info['tags']?explode(",",$post_info['tags']):[];

        foreach($tags_arr as $_tag){
            $has_in = PostsTags::findOne(['posts_id' => $post_id,"tag" => $_tag]);
            if($has_in){
                continue;
            }
            $model_posts_tag = new PostsTags();
            $model_posts_tag->posts_id = $post_id;
            $model_posts_tag->tag = $_tag;
            $model_posts_tag->save(0);
        }
    }

}