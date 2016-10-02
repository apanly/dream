<?php

namespace console\modules\report\controllers;

use common\components\HttpClient;

/*
 * 抓取umeng统计的数据，用于分析
 * */
class Grab_umengController extends Stat_utilController{

    /*
     * php yii report/grab_umeng/keywords
     * 需要获取
     * 1：关键次
     * */

    public function actionKeywords( $param_date = 'Today' ){
        $date = date('Y-m-d', strtotime($param_date));
        $cookie = $this->getAuthCookie( 2 );
        $url = "https://web.umeng.com/main.php?c=site&a=overview&ajax=module=report&siteid=1259302647&st=2016-10-02&et=2016-10-02&type=Line&Quota=pv,uv,ip&Period=Hour&lst={$date}&let={$date}&downloadType=csv";
        HttpClient::setCookie( $cookie );
        $ret = HttpClient::get( $url );
        if( !$ret ){
            $this->echoLog( HttpClient::getLastErrorMsg() );
            return;
        }
        $params = [
            'type' => 1,
            'action' => 2,
            'date' => $date
        ];

        $this->save2File( "keywordlist_umeng_{$date}".date("YmdHis").".csv" ,$ret,$params);
    }
}