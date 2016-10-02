<?php

namespace console\modules\report\controllers;

use common\models\report\ReportAuthHistory;
use yii\console\Controller;

class Stat_utilController extends Controller{
    public function echoLog($msg){
        echo date("Y-m-d H:i:s")."：".$msg."\r\n";
        return true;
    }

    public function setAuthCookie(  $cookie ,$type = 1 ){
        if( !$cookie ){
            return false;
        }
        parse_str( str_replace("; ","&",$cookie) ,$cookis_arr );
        $model_auth =  new ReportAuthHistory();
        $model_auth->type = $type;
        $model_auth->params = json_encode( $cookis_arr );
        $model_auth->status = 1;
        $model_auth->updated_time = date("Y-m-d H:i:s");
        $model_auth->created_time = $model_auth->updated_time;
        return $model_auth->save( 0 );
    }

    public function getAuthCookie( $type  ){
        if( $type < 1 ){
            return false;
        }
        $auth_info = ReportAuthHistory::find()
            ->where([ 'type' => $type,'status' => 1 ])
            ->orderBy([ 'id' => SORT_DESC ])->one();

        if( !$auth_info ){
            return false;
        }

        $cookie_str = '';
        $cookie_arr = json_decode( $auth_info['params'],true );
        foreach( $cookie_arr as $_key => $_val ){
            $cookie_str .= $_key.'='.$_val."; ";
        }
        return $cookie_str;
    }

    protected function save2File( $filename,$data ){
        file_put_contents( $filename ,$data );
    }
}