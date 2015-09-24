<?php

namespace common\service;


use common\models\search\SpiderQueue;

class SpiderService {

    public static function add($url){
        $ret = [
            'code' => 200,
            'data' => []
        ];
        $has_in = SpiderQueue::findOne(['hash_url' => $url]);
        if($has_in){
            $ret['data'] = $has_in;
            return $ret;
        }

        $date_now = date("Y-m-d H:i:s");
        $model_queue = new SpiderQueue();
        $model_queue->url = $url;
        $model_queue->hash_url = md5($url);
        $model_queue->status = -2 ;
        $model_queue->updated_time = $date_now;
        $model_queue->created_time = $date_now;
        $model_queue->save(0);
        return $ret;
    }

} 