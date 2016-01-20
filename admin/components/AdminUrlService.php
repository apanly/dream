<?php
namespace admin\components;

use Yii;
use yii\helpers\Url;

class AdminUrlService
{
    public static function buildUrl($uri, $params = []){
        $path = Url::toRoute(array_merge([$uri], $params));
        $domain_blog = \Yii::$app->params['domains']['admin'];
        return $domain_blog.$path;
    }
} 
