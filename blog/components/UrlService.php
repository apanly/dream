<?php
namespace blog\components;

use common\service\GlobalUrlService;
use Yii;
use yii\helpers\Url;

class UrlService
{
    public static function buildUrl($uri, $params = []){
        return GlobalUrlService::buildBlogUrl($uri, $params);
    }


    public static function buildWapUrl($uri, $params = []){;
        return GlobalUrlService::buildWapUrl($uri, $params);
    }


    public static function buildGameUrl($uri, $params = []){
        return GlobalUrlService::buildGameUrl($uri, $params);
    }

    public static function buildMateUrl($uri, $params = []){
        return GlobalUrlService::buildMateUrl( $uri, $params );
    }
} 
