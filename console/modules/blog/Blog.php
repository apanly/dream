<?php

namespace console\modules\blog;
use yii\console\Controller;


abstract class Blog extends Controller {

    public function echoLog($msg){
        echo date("Y-m-d H:i:s")."：".$msg."\r\n";
        return true;
    }

    public function getCurId($path){
        if( !file_exists( $path) ){
            return 0;
        }
        $id = file_get_contents($path);
        return intval( $id );
    }

    public function setCurId($path,$id){
        file_put_contents($path,$id);
    }

}