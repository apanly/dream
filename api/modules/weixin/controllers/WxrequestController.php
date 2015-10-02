<?php
namespace api\modules\weixin\controllers;

use api\modules\weixin\controllers\common\BaseController;
use common\components\HttpLib;
use \yii\caching\FileCache;
use Yii;
class WxrequestController extends BaseController{

    private static $url = "https://api.weixin.qq.com/cgi-bin/";

    public static function send($path,$data=[],$method = "GET"){

        $request_url = self::$url.$path;

        $http = new HttpLib();
        if($method == "POST"){
            $res = $http->post($request_url,$data);
        }else{
            $res = $http->get($request_url,[]);
        }
        return $res['body'];
    }

    public static function getAppId(){
        return Yii::$app->params['weixin']['appid'];
    }

    public static function getAppSec(){
        return Yii::$app->params['weixin']['appsec'];
    }

    public static function getToken(){
        return Yii::$app->params['weixin']['token'];
    }

    public static function getAccessToken($force = false){

        $cacheTokenKey = 'wx_access_token';

        $cache = new FileCache();
        $data = $cache[$cacheTokenKey];
        $access_token = "";

        if(!$data){
            $force = true;
        }else{
            $jsonData = @json_decode($data,true);
            if($jsonData['expire_time'] < time()){
                $force = true;
            }else{
                $access_token = $jsonData['access_token'];
            }
        }
        if ($force) {

            $path = 'token?grant_type=client_credential&appid='.self::getAppId().'&secret='.self::getAppSec();
            $res = self::send($path);

            $resData = json_decode($res,true);
            if(isset($resData['errcode']) && $resData['errcode'] != 0){
                return false;
            }

            $access_token  = $resData['access_token'];

            if ($access_token) {
                $cache[$cacheTokenKey] = json_encode(['expire_time'=>time() + 3600,'access_token'=>$access_token]);
            }
        }

        return $access_token;
    }



}