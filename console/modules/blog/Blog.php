<?php

namespace console\modules\blog;
use yii\console\Controller;


abstract class Blog extends Controller {

    public function echoLog($msg){
        echo $msg."\r\n";
        return true;
    }
}