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
        if( $this->checkHasFileByDate( 2,$date ) ){
            return $this->echoLog("has file,date:{$date} ");
        }
        $cookie = $this->getAuthCookie( 2 );
        $url = "https://web.umeng.com/main.php?c=traf&a=keyword&ajax=module=report&siteid=1259302647&st={$date}&et={$date}&tabIndex=1&keywordCondType=&keyword=&itemName=&itemNameType=&itemVal=&engin=all&orderBy=pv&orderType=-1&currentPage=1&pageType=90&downloadType=csv";
        HttpClient::setCookie( $cookie );
        $ret = HttpClient::get( $url );
        if( !$ret ){
            $this->echoLog( HttpClient::getLastErrorMsg() );
            return;
        }
        $params = [
            'type' => 2,
            'action' => 1,
            'date' => $date
        ];

        $this->save2File( "keywordlist_umeng_{$date}_".date("YmdHis").".csv" ,$ret,$params);
    }
}