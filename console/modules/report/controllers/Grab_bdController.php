<?php

namespace console\modules\report\controllers;

use common\components\HttpClient;

class Grab_bdController extends Stat_utilController{
    /*
     * 百度的统计
     * 百度统计地址：http://tongji.baidu.com/web/21698230/trend/time?siteId=9585019&flag=month
     * zhanzhang.baidu.com 是站长工具了
     * php yii report/grab_bd/keywords
     * 需要获取
     * 1：关键次
     * */
    public function actionKeywords( $param_date = 'Today' ){
        $date = date('Y-m-d', strtotime($param_date));
        if( $this->checkHasFileByDate( 1,$date ) ){
            //return $this->echoLog("has file,date:{$date} ");
        }

        $cookie = $this->getAuthCookie( 1 );
        $url = "http://zhanzhang.baidu.com/keywords/keywordlist?site=http%3A%2F%2Fwww.vincentguo.cn%2F&range={$date}&download=true&searchItem=";
        HttpClient::setCookie( $cookie );
        $ret = HttpClient::get( $url );

        if( stripos( $ret,'Too many downloads' ) !== false ){//错误了
            $this->echoLog( $ret );
            return;
        }

        if( !$ret ){
            $this->echoLog( HttpClient::getLastErrorMsg() );
            return;
        }
        $params = [
            'type' => 1,
            'action' => 1,
            'date' => $date
        ];
        $this->save2File("keywordlist_bd_{$date}_".date("YmdHis").".csv" ,$ret,$params);
    }

}