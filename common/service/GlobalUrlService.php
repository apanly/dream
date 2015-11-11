<?php
namespace common\service;


class GlobalUrlService {
    public static function buildStaticUrl($path){
        $domain = \Yii::$app->params['domains']['static'];
        return $domain.$path;
    }
} 