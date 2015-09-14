<?php
namespace api\modules\weixin\controllers;

use api\modules\weixin\controllers\common\BaseController;
use Yii;
class WxrequestController extends BaseController{

    private static $url = "https://api.weixin.qq.com/cgi-bin/";

    public static function getAppId(){
        return Yii::$app->params['weixin']['appid'];
    }

    public static function getAppSec(){
        return Yii::$app->params['weixin']['appsec'];
    }

    public static function getToken(){
        return Yii::$app->params['weixin']['token'];
    }

}