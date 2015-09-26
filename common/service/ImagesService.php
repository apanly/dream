<?php

namespace common\service;




use common\models\Images;

class ImagesService {

    public static function add($hash_key,$filename,$filepath,$file_url,$target_id = 0){
        $model_image = new Images();
        $model_image->hash_key = $hash_key;
        $model_image->filename = $filename;
        $model_image->filepath = $filepath;
        $model_image->file_url = $file_url;
        $model_image->target_id = $target_id;
        $model_image->created_time = date("Y-m-d H:i:s");
        $model_image->save(0);
    }
} 