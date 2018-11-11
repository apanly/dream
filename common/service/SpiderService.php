<?php

namespace common\service;


use common\models\search\SpiderQueue;

class SpiderService {

    public static $allow_hosts = [
        "mp.weixin.qq.com" => 'mp',
        "www.jianshu.com" => "jianshu",
        "blog.devtang.com" => "devtang",
        "blog.csdn.net" => "csdn",
        "blog.jobbole.com" => "jobbole"
    ];

    public static function add($url){
        $ret = [
            'code' => 200,
            'data' => []
        ];

        $has_in = SpiderQueue::findOne(['hash_url' => md5($url) ]);
        if($has_in){
            $ret['data'] = $has_in;
            return $ret;
        }

        $date_now = date("Y-m-d H:i:s");
        $model_queue = new SpiderQueue();
        $model_queue->url = $url;
        $model_queue->hash_url = md5($url);
        $model_queue->status = -2 ;
        $model_queue->post_id = 0 ;
        $model_queue->updated_time = $date_now;
        $model_queue->created_time = $date_now;
        $model_queue->save(0);
        return $ret;
    }

    public static function getDomain( $search_key ){
        return array_search($search_key,self::$allow_hosts);
    }
} 