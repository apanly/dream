<?php
namespace common\service;


class GlobalUrlService {
    public static function buildStaticUrl($path){
        $domain = \Yii::$app->params['domains']['static'];
        return $domain.$path;
    }

    public static function buildUrl($path,$bucket = 'blog',$default_bucket = 'blog'){
        $domains = \Yii::$app->params['domains'];
        if( isset($domains[$bucket]) ){
            $domain = $domains[$bucket];
        }else{
            $domain = $domains[$default_bucket];
        }
        return $domain.$path;
    }
} 