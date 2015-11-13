<?php

namespace common\service;




use common\components\UploadService;
use common\models\games\Doubanmz;

class DoubanmzService {

    public static function add($title,$url){
        $hash_key = md5($url);
        $has_in = Doubanmz::findOne(['hash_key' => $hash_key]);
        if( $has_in ){
            return true;
        }
        $tmp_ret = UploadService::uploadByUrl($url,"","pic2");

        $model_doubanmz = new Doubanmz();
        $model_doubanmz->hash_key = $hash_key;
        $model_doubanmz->title = $title;
        $model_doubanmz->src_url = $url;
        $model_doubanmz->image_url = $tmp_ret?$tmp_ret['uri']:'';
        $model_doubanmz->status = 1;
        $model_doubanmz->created_time = date("Y-m-d H:i:s");
        $model_doubanmz->save(0);
        return true;
    }
} 