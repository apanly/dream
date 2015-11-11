<?php
namespace blog\components;

use Yii;
use yii\helpers\Url;

class UrlService
{
    public static function buildUrl($uri, $params = [])
    {
        return Url::toRoute(array_merge([$uri], $params));
    }


    public static function buildWapUrl($uri, $params = [])
    {
        $uri = "/" . $uri;
        return Url::toRoute(array_merge([$uri], $params));
    }


    public static function buildGameUrl($uri, $params = [])
    {
        $uri = "/game" . $uri;
        return Url::toRoute(array_merge([$uri], $params));
    }

} 
