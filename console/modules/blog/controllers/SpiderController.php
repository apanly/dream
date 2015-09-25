<?php

namespace console\modules\blog\controllers;

use common\components\HttpLib;
use common\models\search\SpiderQueue;
use console\modules\blog\Blog;

class SpiderController extends Blog{

    private $route_mapping = [
        "mp.weixin.qq.com" => 'mp'
    ];

    public function actionRobot(){

        $queue_list = SpiderQueue::find()
            ->where(['status' => -2])
            ->orderBy("id asc")
            ->limit(1)
            ->all();

        if( !$queue_list ){
            $this->echoLog("no data");
            return;
        }

        foreach( $queue_list as $_info ){

            $tmp_url_info = parse_url($_info['url']);
            $tmp_host = $tmp_url_info['host'];
            if( !isset( $this->route_mapping[ $tmp_host ] ) ){
                continue;
            }

            $tmp_action = $this->route_mapping[ $tmp_host ];
            $content = call_user_func_array([$this,"crawl_{$tmp_action}"],[ $_info['url'] ]);

        }

    }

    private function crawl_mp($url){
        $content = $this->getContentByUrl($url);
        if(!$content){
            return false;
        }
        //echo $content;
        $reg_rule = "/<div\s*class=\"rich_media_content\"\s*id=\"js_content\">(.*?)<\/div><script/is";
        preg_match($reg_rule,$content,$matches);
        var_dump($matches);
        return time();
    }


    private function getContentByUrl($url){
        $target = new HttpLib();
        $ret = $target->get($url);
        if( $ret['response']['code'] == 200 ){
            return $ret['body'];
        }
        return false;
    }
}