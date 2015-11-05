<?php

namespace console\modules\blog\controllers;

use common\components\HttpLib;
use common\service\DoubanmzService;
use console\modules\blog\Blog;

class DbmzController extends Blog{
    /*
     * http://huaban.com/boards/25007076/ 这个网站需要加入进来
     * */
    public function actionRun(){
        $url = "http://www.dbmeinv.com/?p=&pager_offset=";
        for($idx = 10 ;$idx >= 1;$idx-- ){
            $this->crawl_mp($url.$idx);
            sleep(3);
        }
    }

    private function crawl_mp($url){
        $this->echoLog("---------{$url}--------");

        $content = $this->getContentByUrl($url);
        if(!$content){
            return false;
        }

        $ret = [];
        $reg_rule = "/<ul\s*class=\"thumbnails\">(.*?)<\/ul>/is";
        preg_match($reg_rule,$content,$matches);
        if( $matches && isset( $matches[1] ) && $matches[1] ){
            $item_content = $matches[1];
            $reg_li_rule = "/<li\s*class=\"span3\">(.*?)<\/li>/is";
            preg_match_all($reg_li_rule,$item_content,$li_matches);
            if( $li_matches && isset( $li_matches[1] ) && $li_matches[1] ){
                foreach($li_matches[1] as $item_li){
                    $ret[] = $this->getImgItems($item_li);
                }
            }

            foreach($ret as $_img_item){
                if( $_img_item ){
                    DoubanmzService::add($_img_item['title'],$_img_item['src']);
                }

            }
        }

    }

    private function getImgItems($li_content){
        $data = [];
        preg_match('/<\s*img\s+([^>]*?)\/\s*>/i',$li_content,$matches);
        if( $matches && isset( $matches[1] ) && $matches[1] ){
            $tmp = explode('"',$matches[1]);
            if( count( $tmp ) == 11 ){
                $data = [
                    "title" => trim( $tmp[3] ),
                    "src"   => trim( $tmp[9] )
                ];
            }
        }
        return $data;
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