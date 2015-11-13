<?php
/**
 * Class BaseController
 */

namespace console\controllers;


class BaseController extends  \yii\console\Controller {
    public function echoLog($msg){
        echo $msg."\r\n";
        return true;
    }

    //preg_match('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$content,$match_img);
} 