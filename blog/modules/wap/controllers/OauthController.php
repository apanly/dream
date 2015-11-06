<?php
namespace blog\modules\wap\controllers;

use blog\components\UrlService;
use \blog\modules\wap\controllers\common\BaseController;
use common\components\HttpClient;
use common\components\HttpLib;
use Yii;

class OauthController extends BaseController{

    private $appid = '';
    private $appsecret = '';


    public function actionLogin(){
        $this->setWeixinConfig();
        $type = $this->get("type","snsapi_base");

        $redirect_uri = "http://m.vincentguo.cn/oauth/token";
        $appid = $this->appid;
        $refer = "/";
        $url =  "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope={$type}&state={$refer}#wechat_redirect";
        return $this->redirect($url);
    }

    public function actionToken(){
        $this->setWeixinConfig();
        $code = isset($_GET['code'])?$_GET['code']:'';
        $state = isset($_GET['state'])?$_GET['state']:'';
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
        var_dump($data);
    }

    protected function setWeixinConfig(){
        $weixin = Yii::$app->params['weixin']['oauth'];
        $this->appid = $weixin["appid"];
        $this->appsecret = $weixin['appsecret'];
    }
}
