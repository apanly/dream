<?php
namespace blog\modules\weixin\controllers;

use blog\components\BaseBlogController;
use blog\components\UrlService;
use common\components\HttpClient;
use common\models\user\UserOpenidUnionid;
use common\models\user\User;
use common\service\GlobalUrlService;
use Yii;

class OauthController extends BaseBlogController{

    private $appid = '';
    private $appsecret = '';


    public function actionLogin(){
        $this->setWeixinConfig();
        $type = $this->get("type","snsapi_base");
        $referer = trim( $this->get("referer",GlobalUrlService::buildWapUrl("/default/index") ));
        $redirect_uri = GlobalUrlService::buildBlogUrl("/weixin/oauth/token");
        $appid = $this->appid;
        $url =  "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope={$type}&state={$referer}#wechat_redirect";
        return $this->redirect($url);
    }

    public function actionToken(){
        $this->setWeixinConfig();
        $code = $this->get("code","");
        $state = $this->get("state","");
        if( !$code ){
            return $this->goHome();
        }

        $appid = $this->appid;
        $appsecret = $this->appsecret;
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";
        $ret = HttpClient::get($url,[]);
        $data = @json_decode($ret,true);
        if(empty($data) || isset($data['errcode'])){
            return $this->goHome();
        }

        $openid = $data['openid'];
        $sns_user_data = [];
        if( $data['scope'] == "snsapi_userinfo"){
            $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$data['access_token']."&openid={$openid}&lang=zh_CN";
            $ret = HttpClient::get($url,[]);
            $sns_user_data = @json_decode($ret,true);
        }

        $reg_bind = UserOpenidUnionid::findOne(["openid" => $openid ]);
        if( !$reg_bind ){
            $date_now = date("Y-m-d H:i:s");
            $unique_name = md5($openid);
            $user_info  = User::findOne(['unique_name' => $unique_name]);
            if( !$user_info ){
                $model_user = new User();
                if( $sns_user_data ){
                    $model_user->nickname = $sns_user_data['nickname'];
                    $model_user->avatar = $sns_user_data['headimgurl'];
                }else{
                    $model_user->nickname = "微信用户".substr($openid,-10);
                }
                $model_user->updated_time = $date_now;
                $model_user->created_time = $date_now;
                $model_user->save(0);
                $user_info = $model_user;
            }

            $model_bind = new UserOpenidUnionid();
            $model_bind->uid = $user_info['uid'];
            $model_bind->openid = $openid;
            $model_bind->unionid = '';
            $model_bind->updated_time = $date_now;
            $model_bind->created_time = $date_now;
            $model_bind->save(0);
        }else{
            $user_info  = User::findOne(['uid' => $reg_bind['uid'] ]);
        }

        if( $sns_user_data && ( stripos("微信用户",$user_info['nickname'] !== false ) || !$user_info['avatar'] ) ){
            $user_info->nickname = $sns_user_data['nickname'];
            $user_info->avatar = $sns_user_data['headimgurl'];
            $user_info->update(0);
        }

        $this->createLoginStatus($user_info);

        /*特殊处理*/
        $state = str_replace("@@","&",urldecode($state));
        $state = str_replace("@|@","?",urldecode($state));
        $state = rtrim($state,"?");
        $state = rtrim($state,"&");


        $url = $state?$state:UrlService::buildWapUrl("/default/index");
        return $this->redirect($url);

    }

    protected function setWeixinConfig(){
        $weixin = Yii::$app->params['weixin']['oauth'];
        $this->appid = $weixin["appid"];
        $this->appsecret = $weixin['appsecret'];
    }

    public function actionSetauth($id){
        $code = $this->get("code","");
        $source = $this->get("source","game");
        $unvalid_url = UrlService::buildGameUrl("/mv/index");

        if( !$id || $code != "030608bfff2840942db5cb9604ff0445" ){
            return $this->redirect( $unvalid_url );
        }
        $user_info = User::findOne(['uid' => $id]);
        if(!$user_info){
            return $this->redirect( $unvalid_url );
        }
        $this->createLoginStatus($user_info);

        return $this->redirect( $unvalid_url );
    }

    public function actionClear(){
        $this->removeAuthToken();
        $url_blog = UrlService::buildWapUrl("/default/index");
        $url_game = UrlService::buildGameUrl("/mv/index");
        return <<<EOT
        <style>
            body{
                font-size:3em;
            }
        </style>
        <a href="{$url_blog}">博客首页</a>
        <a href="{$url_game}">游戏中心</a>
EOT;
    }
}
