<?php

namespace console\controllers;

use common\components\UploadService;
use common\models\posts\Posts;
use common\service\GlobalUrlService;

class TransferController extends  BaseController {
    public function actionReplace(){
        $post_list = Posts::find()->where(['status' => 1])->orderBy("id desc")->all();
        if($post_list){
            $domain_pic1 = \Yii::$app->params['domains']['pic1'];
            foreach( $post_list as $_post_info ){
                $this->echoLog("post_id:{$_post_info['id']}");
                $tmp_content = $_post_info['content'];
                preg_match_all('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$tmp_content,$match_img);
                if( $match_img && count($match_img) == 3 ){
                    foreach($match_img[2] as $_img_src){
                        if( stripos($_img_src,$domain_pic1 ) === false ){
                            continue;
                        }
                        $tmp_parse = parse_url($_img_src);
                        if( $tmp_parse && isset( $tmp_parse['path'] ) ){
                            $tmp_url = GlobalUrlService::buildPic1Static($tmp_parse['path'],['w' => 600]);
                            $tmp_content = str_replace($_img_src,$tmp_url,$tmp_content);
                        }

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

    private function downImg($src_url){
        $ret = UploadService::uploadByUrl($src_url);
        return $ret?$ret['url']:false;
    }

    public function actionTest(){
        var_dump($a);
    }
} 