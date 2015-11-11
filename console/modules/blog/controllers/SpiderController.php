<?php

namespace console\modules\blog\controllers;

use admin\components\BlogService;
use common\components\HttpLib;
use common\components\phpanalysis\FenCiService;
use common\components\UploadService;
use common\models\posts\Posts;
use common\models\search\SpiderQueue;
use common\service\ImagesService;
use common\service\SpiderService;
use console\modules\blog\Blog;
use \Yii;


class SpiderController extends Blog{

    public function actionRobot(){

        $date_now = date("Y-m-d H:i:s");

        $queue_list = SpiderQueue::find()
            ->where(['status' => -2])
            ->orderBy("id asc")
            ->limit(1)
            ->all();

        if( !$queue_list ){
            $this->echoLog("{$date_now} -- no data");
            return;
        }

        $route_mapping = SpiderService::$allow_hosts;


        foreach( $queue_list as $_info ){

            $_info->status = -1;
            $_info->update(0);

            $tmp_url_info = parse_url($_info['url']);
            $tmp_host = $tmp_url_info['host'];
            if( !isset( $route_mapping[ $tmp_host ] ) ){
                $this->echoLog("-------queue_id:{$_info['id']},date:{$date_now},not allow host url:{$_info['url']}----------");
                $_info->status = 0;
                $_info->update(0);
                continue;
            }

            $this->echoLog("-------queue_id:{$_info['id']},date:{$date_now},url:{$_info['url']}----------");

            $tmp_action = $route_mapping[ $tmp_host ];
            $ret = call_user_func_array([$this,"crawl_{$tmp_action}"],[ $_info['url'] ]);
            if( !$ret ){
                $_info->status = 0;
                $_info->update(0);
                continue;
            }

            $post_id = $this->save2blog($ret['content'],$ret['title'],$_info['url'] );
            if( !$post_id ){
                $_info->status = 0;
                $_info->update(0);
                continue;
            }

            $_info->post_id = $post_id;
            $_info->status = 1;
            $_info->update(0);
        }

    }

    private function crawl_mp($url){
        $ret = [];
        $content = $this->getContentByUrl($url);
        if(!$content){
            return $ret;
        }

        $reg_rule = "/<div\s*class=\"rich_media_content\s*\"\s*id=\"js_content\">(.*?)<\/div>\s*<script/is";
        preg_match($reg_rule,$content,$matches);

        if( $matches && $matches[1] ){
            $ret['content'] = trim( $matches[1] );
            //$ret['content'] = str_replace("data-src","src",$ret['content']);//微信图片不能盗用
        }

        $reg_rule = "/<h2\s*class=\"rich_media_title\"\s*id=\"activity-name\">(.*?)<\/h2>/is";
        preg_match($reg_rule,$content,$matches);
        if( $matches && $matches[1] ){
            $ret['title'] = trim( $matches[1] );
        }

        return $ret;
    }

    private function crawl_jianshu($url){
        $ret = [];
        $content = $this->getContentByUrl($url);
        if(!$content){
            return $ret;
        }
        $reg_rule = "/<div\s*class=\"show-content\">(.*?)<\/div>\s*<\/div>/is";
        preg_match($reg_rule,$content,$matches);
        if( $matches && $matches[1] ){
            $ret['content'] = trim( $matches[1] );
        }
        $reg_rule = "/<h1\s*class=\"title\">(.*?)<\/h1>/is";
        preg_match($reg_rule,$content,$matches);
        if( $matches && $matches[1] ){
            $ret['title'] = trim( $matches[1] );
        }

        return $ret;
    }

    private function crawl_devtang($url){
        $ret = [];
        $content = $this->getContentByUrl($url);
        if(!$content){
            return $ret;
        }
        $reg_rule = "/<div\s*class=\"entry-content\">(.*?)<\/div>\s*<footer>/is";
        preg_match($reg_rule,$content,$matches);
        if( $matches && $matches[1] ){
            $ret['content'] = trim( $matches[1] );
        }

        /*替换img*/
        if( $ret['content'] ){
            preg_match_all('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$ret['content'],$match_img);
            if( $match_img && count($match_img) == 3 ){
                foreach( $match_img[2] as $_img_src){
                    if( !preg_match("/^http/",$_img_src) ){
                        $tmp_down_url = "http://".SpiderService::getDomain("devtang").$_img_src;
                    }else{
                        $tmp_down_url = $_img_src;
                    }
                    $full_img_url = $this->downImg($tmp_down_url)."?format=/w/300";
                    $ret['content'] = str_replace($_img_src,$full_img_url,$ret['content']);
                }
            }
        }

        $reg_rule = "/<h1\s*class=\"entry-title\">(.*?)<\/h1>/is";
        preg_match($reg_rule,$content,$matches);
        if( $matches && $matches[1] ){
            $ret['title'] = trim( $matches[1] );
        }

        return $ret;
    }

    private function crawl_jobbole($url){
        $ret = [];
        $content = $this->getContentByUrl($url);
        if(!$content){
            return $ret;
        }
        $reg_rule = "/<div\s*class=\"entry\">(.*?)<\/div>\s*<!-- END .entry -->/is";
        preg_match($reg_rule,$content,$matches);
        if( $matches && $matches[1] ){
            $search = [
                "'<script[^>]*?>.*?</script>'si", // 去掉 javascript
                "'<style[^>]*?>.*?</style>'si", // 去掉 css
                "'<div\s*class=\'copyright-area\'>.*?</div>'si",
                "'<div\s*class=\"post-adds\">.*?</div>\s*</div>'si",
                "'<!-- BEGIN #author-bio -->'",
                "'<!-- END #author-bio -->'"
            ];
            $replace = [
                "",""
            ];
            $ret['content'] = trim( preg_replace($search,"",$matches[1]) );

        }

        $reg_rule = "/<div\s*class=\"entry-header\">\s*<h1>(.*?)<\/h1>\s*<\/div>/is";
        preg_match($reg_rule,$content,$matches);
        if( $matches && $matches[1] ){
            $ret['title'] = trim( $matches[1] );
        }

        return $ret;
    }

    private function getContentByUrl($url){
        $target = new HttpLib();
        $ret = $target->get($url);
        if( $ret['response']['code'] == 200 ){
            return $ret['body'];
        }
        return false;
    }

    private function save2blog($content,$title,$url){

        if( !$content || !$title ){
            return false;
        }

        $content .= "<p>Robot抓取来源:<a href='{$url}' target='_blank'>去原网站</a></a>";

        $model_post = new Posts();
        $model_post->uid = 0;
        $model_post->title = $title;
        $model_post->type = 1;
        $model_post->status = 0;//先审核后在展示
        $model_post->content = $content;
        $tags = FenCiService::getTags($content);
        $model_post->tags = implode(",",$tags);
        $model_post->updated_time = date("Y-m-d H:i:s");
        $model_post->created_time = $model_post->updated_time;
        if( $model_post->save(0) ){
            //BlogService::buildTags($model_post->id);//隐藏的不需要tag
            return $model_post->id;
        }
        return false;
    }

    private function downImg($src_url){
        $ret = UploadService::uploadByUrl($src_url);
        return $ret?$ret['url']:false;
    }

}