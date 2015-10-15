<?php

namespace common\service;




use common\models\Images;

class ImagesService {

    public static function add($bucket,$hash_key,$filename,$save_path,$file_url,$target_id = 0){
        $model_image = new Images();
        $model_image->bucket = $bucket;
        $model_image->hash_key = $hash_key;
        $model_image->filename = $filename;
        $model_image->filepath = $save_path;
        $model_image->file_url = $file_url;
        $model_image->target_id = $target_id;
        $model_image->created_time = date("Y-m-d H:i:s");
        $model_image->save(0);
    }

    public static function checkHashKey($hash_key){
        return  Images::findOne(['hash_key' => $hash_key]);
    }
} 