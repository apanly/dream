<?php

namespace blog\controllers;

use blog\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\user\User;
use common\service\CacheService;
use dosamigos\qrcode\lib\Enum;
use dosamigos\qrcode\QrCode;
use \yii\caching\FileCache;
use Yii;


class DemoController extends BaseController {
    public function actionScan(){
        $key  = $this->getCookie("qrcode", "");
        $flag = false;
        if (!$key) {
            $flag = true;
        } else {
            $cache_status = $this->getCache($key);
            if (!$cache_status || ($cache_status != -1)) {
                $flag = true;
            }
        }

        if ($flag) {
            $key        = $this->getKey();
            $cache_time = 5 * 60;
            $this->setCookie("qrcode", $key, $cache_time);
            $this->setCache($key, -1, $cache_time); //-1 表示没登陆
        }

        return $this->render("scan");
    }

    public function actionQrcode(){
        $key     = $this->getCookie("qrcode", "no");
        $domains = Yii::$app->params['domains'];
        $url     = $domains["blog"] . "/demo/login?key={$key}";
        header('Content-type: image/png');
        QrCode::png($url, false, Enum::QR_ECLEVEL_H, 8, 0, false);
        exit();
    }

    public function actionLogin(){
        $key = trim($this->get("key", ""));
        if (!$key || $key == "no") {
            return $this->renderJSON([], "扫描登录失败!", -1);
        }

        $cache_status = $this->getCache($key);
        if (!$cache_status || ($cache_status != -1)) {
            return $this->renderJSON([], "扫描登录失败!", -1);
        }

        $this->setCache($key, 1); //表示登录成功

        return $this->renderJSON([], "", 200);
    }

    public function actionDologin(){
        $key = trim($this->getCookie("qrcode", ""));
        if (!$key || $key == "no") {
            return $this->renderJSON([], "扫描登录失败!{$key}", -1);
        }

        if (!$this->existCache($key)) {
            return $this->renderJSON([], "刷新页面!", 201);
        }

        $cache_status = $this->getCache($key);

        if ($cache_status < 1) {
            return $this->renderJSON([], "还没有登录!", -1);
        }

        $user_info = User::findOne(['uid' => $cache_status]);
        $data      = [
            "nickname" => DataHelper::encode($user_info["nickname"]),
            "email"    => "apanly@163.com"
        ];
        return $this->renderJSON($data, "", 200);
    }

    private function getKey()
    {
        $key = base64_encode(md5(microtime(true) . $this->getUniqueId()));
        return mb_substr($key, -8);
    }

    private function setCache($key, $value, $expire = 0)
    {
        $cache = new FileCache();
        if ($this->existCache($key)) {
            $jsonData    = @json_decode($cache[$key], true);
            $cache[$key] = json_encode(['expire_time' => $jsonData['expire_time'], 'value' => $value]);
        } else {
            $cache[$key] = json_encode(['expire_time' => time() + $expire, 'value' => $value]);
        }

    }

    private function getCache($key){
        $cache = new FileCache();
        $data  = $cache[$key];
        if (!$data) {
            return false;
        }

        $jsonData = @json_decode($data, true);

        if ($jsonData['expire_time'] < time()) {
            $cache->delete($key);
            return false;
        }

        return $jsonData['value'];

    }

    private function existCache($key){
        $cache = new FileCache();
        $data  = $cache[$key];
        if (!$data) {
            return false;
        }
        return true;
    }

}