<?php

namespace console\controllers;


use common\components\UploadService;
use common\models\games\Doubanmz;
use common\models\library\Book;
use common\models\posts\Posts;

class TransferController extends  BaseController {
    public function actionReplace(){
        $post_list = Posts::find()->where(['status' => 1])->orderBy("id desc")->all();
        if($post_list){
            foreach( $post_list as $_post_info ){
                $this->echoLog("post_id:{$_post_info['id']}");
                $tmp_content = $_post_info['content'];
                preg_match_all('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$tmp_content,$match_img);
                if( $match_img && count($match_img) == 3 ){
                    foreach($match_img[2] as $_img_src){
                        if( stripos($_img_src,\Yii::$app->params['domains']['pic1']) === false ){
                            continue;
                        }
                        $tmp_content = str_replace($_img_src,$full_img_url,$tmp_content);
                    }
                    $_post_info->content = $tmp_content;
                    $_post_info->update(0);
                }
            }
        }
    }

    /*所有的图片都要换成我们自己的*/
    public function actionUse_pic1(){
        $post_list = Posts::find()->where(['status' => 1])->orderBy("id desc")->all();
        if($post_list){
            foreach( $post_list as $_post_info ){
                $this->echoLog("post_id:{$_post_info['id']}");
                $tmp_content = $_post_info['content'];
                preg_match_all('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$tmp_content,$match_img);

                if( $match_img && count($match_img) == 3 ){
                    foreach($match_img[2] as $_img_src){
                        if( stripos($_img_src,\Yii::$app->params['domains']['pic1']) !== false ){
                            continue;
                        }

                        if( stripos($_img_src,"pic1.vincentguo.cn") !== false ){
                            $tmp_content = str_replace("http://pic1.vincentguo.cn",\Yii::$app->params['domains']['pic1'],$tmp_content);
                            continue;
                        }

                        $full_img_url = $this->downImg($_img_src)."?format=/w/300";
                        $tmp_content = str_replace($_img_src,$full_img_url,$tmp_content);
                    }
                    $_post_info->content = $tmp_content;
                    $_post_info->update(0);
                }

            }
        }
    }

    public function actionBook(){
        $list = Book::find()->where(['=','image_url',''])->orderBy("id desc")->all();
        if( !$list ){
            return 'no data';
        }
        foreach( $list as $_item ){
            $this->echoLog("book_id:{$_item['id']}");
            if( !$_item['origin_image_url'] ){
                continue;
            }
            $tmp_ret = UploadService::uploadByUrl($_item['origin_image_url']);
            if( !$tmp_ret ){
                continue;
            }
            $_item->image_url = $tmp_ret['uri'];
            $_item->update(0);
        }
    }

    public function actionMv(){
        $list = Doubanmz::find()->where(['=','image_url',''])->orderBy("id desc")->limit(500)->all();
        if( !$list ){
            return 'no data';
        }
        foreach( $list as $_item ){
            $this->echoLog("mv_id:{$_item['id']}");
            if( !$_item['src_url'] ){
                continue;
            }
            $tmp_ret = UploadService::uploadByUrl($_item['src_url'],"","pic2");
            if( !$tmp_ret ){
                continue;
            }
            $_item->image_url = $tmp_ret['uri'];
            $_item->update(0);
        }
    }

    private function downImg($src_url){
        $ret = UploadService::uploadByUrl($src_url);
        return $ret?$ret['url']:false;
    }
} 