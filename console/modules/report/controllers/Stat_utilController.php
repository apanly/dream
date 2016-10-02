<?php

namespace console\modules\report\controllers;

use common\models\report\ReportAnalyseFiles;
use common\models\report\ReportAuthHistory;
use common\models\report\ReportDailyKeywords;
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

        $model_auth =  new ReportAuthHistory();
        $model_auth->type = $type;
        $model_auth->params = $cookie;
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

        return $auth_info['params'];
    }

    protected function save2File( $filename,$data,$params ){
        if( file_put_contents( $this->getSaveDirPath().$filename ,$data ) ){
            $model_report_file = new ReportAnalyseFiles();
            $model_report_file->type = isset( $params['type'] )?$params['type']:0;
            $model_report_file->action = isset( $params['action'] )?$params['action']:0;
            $model_report_file->file_path = $filename;
            $model_report_file->date = isset( $params['date'] )?$params['date']:'0000-00-00';
            $model_report_file->status = -1;
            $model_report_file->updated_time = date("Y-m-d H:i:s");
            $model_report_file->created_time = $model_report_file->updated_time;
            return $model_report_file->save( 0 );
        }
        return false;
    }

    protected function saveDailyKeyword( $params ){
        if( !$params || !isset( $params['type'] ) || !isset( $params['date'] ) || !isset($params['word']) ){
            return false;
        }
        $date_now = date("Y-m-d H:i:s");
        $uniq_key = md5( implode("_",[ $params['type'],$params['date'],$params['word']  ]) );

        $info = ReportDailyKeywords::findOne(['uniq_key' => $uniq_key ]);

        if( $info ){
            $model_report_keyword = $info;
        }else{
            $model_report_keyword = new ReportDailyKeywords();
            $model_report_keyword->uniq_key = $uniq_key;
            $model_report_keyword->created_time =$date_now;
        }

        foreach( $params as $_key => $_val ){
            $model_report_keyword[ $_key  ] = $_val;
        }
        $model_report_keyword->updated_time = $date_now;
        return $model_report_keyword->save(0);
    }

    protected function getSaveDirPath(){
        return \Yii::$app->params['report']['dir_path'];
    }

    protected function buildFilePath( $filepath ){
        return $this->getSaveDirPath().$filepath;
    }

    protected function checkHasFileByDate( $type,$date ){
        $has_get = ReportAnalyseFiles::find()->where([ 'type' => $type,'date' => $date ])->count();
        return $has_get?true:false;
    }
}