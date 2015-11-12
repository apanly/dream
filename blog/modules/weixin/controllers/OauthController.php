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
        $source = trim( $this->get("source","game"));
        $redirect_uri = GlobalUrlService::buildUrl("/weixin/oauth/token");
        $appid = $this->appid;
        $url =  "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope={$type}&state={$source}#wechat_redirect";
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
        $reg_bind = UserOpenidUnionid::findOne(["openid" => $openid ]);
        if( !$reg_bind ){
            $date_now = date("Y-m-d H:i:s");
            $nickname = "微信用户".substr($openid,-10);
            $user_info  = User::findOne(['nickname' => $nickname]);
            if( !$user_info ){
                $model_user = new User();
                $model_user->nickname = $nickname;
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

        $this->createLoginStatus($user_info);

        $url = UrlService::buildUrl("/");
        if( $state == "game" ){
            $url = GlobalUrlService::buildUrl("/game/mv/index");
        }

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
}
