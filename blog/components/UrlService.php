<?php
namespace blog\components;

use Yii;
use yii\helpers\Url;

class UrlService
{
    public static function buildUrl($uri, $params = []){
        return Url::toRoute(array_merge([$uri], $params));
    }


    public static function buildWapUrl($uri, $params = []){
        if(substr($uri,0,1) != "/") {
            $uri = "/" . $uri;
        }
        $path = Url::toRoute(array_merge([$uri], $params));
        $domain_m = \Yii::$app->params['domains']['m'];
        return $domain_m.$path;
    }


    public static function buildGameUrl($uri, $params = []){
        $path = Url::toRoute(array_merge(["/game" . $uri], $params));
        $domain_blog = \Yii::$app->params['domains']['blog'];
        return $domain_blog.$path;
    }

    public static function buildMateUrl($uri, $params = []){
        $path = Url::toRoute(array_merge(["/mate" . $uri], $params));
        $domain_blog = \Yii::$app->params['domains']['blog'];
        return $domain_blog.$path;
    }
} 
