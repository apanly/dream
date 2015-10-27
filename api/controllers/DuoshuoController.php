<?php

namespace api\controllers;

use common\components\UtilHelper;
use Yii;
use api\controllers\common\AuthController;

class DuoshuoController extends AuthController
{
    private $secret = "ef6e0180e1a4c81b746d3e912248336d";
    private $short_name = 'guowei';
    public function actionCallback(){
        $request = Yii::$app->request;
        if( $request->isPost ){
            $this->recode(var_export($_POST,true));
        }
        $_POST['action'] = 'sync_log';
        $_POST['signature'] = 'v4z+zGQIkiRAPz0S5EDES4qW2vc=';
        $ret = $this->check_signature($_POST);
        var_dump($ret);
        return $this->renderJSON();
    }

    private function check_signature($input){

        $signature = $input['signature'];
        unset($input['signature']);

        ksort($input);
        $baseString = http_build_query($input, null, '&');
        $expectSignature = base64_encode($this->hmacsha1($baseString, $this->secret));
        if ($signature !== $expectSignature) {
            return false;
        }
        return true;
    }

    private function hmacsha1($data, $key) {
        if (function_exists('hash_hmac'))
            return hash_hmac('sha1', $data, $key, true);

        $blocksize=64;
        if (strlen($key)>$blocksize)
            $key=pack('H*', sha1($key));
        $key=str_pad($key,$blocksize,chr(0x00));
        $ipad=str_repeat(chr(0x36),$blocksize);
        $opad=str_repeat(chr(0x5c),$blocksize);
        $hmac = pack(
            'H*',sha1(
                ($key^$opad).pack(
                    'H*',sha1(
                        ($key^$ipad).$data
                    )
                )
            )
        );
        return $hmac;
    }

}