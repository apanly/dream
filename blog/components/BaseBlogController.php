<?php
namespace blog\components;

use Yii;

class BaseBlogController extends \common\components\BaseWebController{

    public $auth_cookie_name = "m_vincentguo";
    public  $salt = "cr5s6fwPKgKrSvpTNd971ea8fbc47";

    public  function createLoginStatus($user_info){
        $auth_token = $this->geneAuthToken($user_info['uid'],$user_info['nickname']);
        $this->setCookie($this->auth_cookie_name,$auth_token."#".$user_info['uid']);
    }

    public  function removeAuthToken(){
        $this->removeCookie($this->auth_cookie_name);
    }

    public function geneAuthToken($uid,$nickname){
        return md5($this->salt."-{$uid}-{$nickname}");
    }
}