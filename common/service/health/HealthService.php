<?php

namespace common\service\health;


use common\models\health\HealthDay;
use common\models\health\HealthLog;

class HealthService {
    public static function setLog($params){
        $date = date("Ymd",strtotime($params['time_from']) );
        $hash_key = md5($date."_".$params['time_from']."_".$params['time_to']);
        if( HealthLog::findOne(['hash_key' => $hash_key]) ){
            return true;
        }

        $model_health_log = new HealthLog();
        $model_health_log->date = $date;
        $model_health_log->quantity = $params['quantity'];
        $model_health_log->time_from = $params['time_from'];
        $model_health_log->time_to = $params['time_to'];
        $model_health_log->hash_key = $hash_key;
        $model_health_log->created_time = date("Y-m-d H:i:s");
        $model_health_log->save(0);
        return true;
    }

    public static function setDay($date){
        $date_now = date("Y-m-d H:i:s");
        $tmp_quantity = HealthLog::find()->where(['date' => $date])->sum("quantity");
        $health_day_info = HealthDay::findOne(['date' => $date]);
        if( $health_day_info ){
            $model_health_day = $health_day_info;
        }else{
            $model_health_day = new HealthDay();
            $model_health_day->date = $date;
            $model_health_day->created_time = $date_now;
        }
        $model_health_day->quantity = $tmp_quantity?$tmp_quantity:0;
        $model_health_day->updated_time = $date_now;
        $model_health_day->save(0);
        return true;
    }
} 