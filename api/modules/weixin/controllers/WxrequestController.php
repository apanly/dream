<?php
namespace api\modules\weixin\controllers;

use api\modules\weixin\controllers\common\BaseController;
use Yii;
class WxrequestController extends BaseController{

    public static $token = "cf25f6d148424332";
    private static $appid = "wxc825b6f93f3c89e5";
    private static $appsecret = "3d652be8cd59d28910d1176de91f58e7";

    private static $url = "https://api.weixin.qq.com/cgi-bin/";

}