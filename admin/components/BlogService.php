<?php

namespace admin\components;


use common\models\posts\Posts;
use common\models\posts\PostsTags;

class BlogService {
    public static function buildTags($post_id){

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