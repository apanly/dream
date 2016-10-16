<?php
namespace console\modules\report\controllers;


use common\models\applog\AccessLogs;
use common\models\applog\StatDailyAccessSource;

class Stat_dailyController extends Stat_utilController{
	/*
	 * php yii report/stat_daily/source
	 * */
	public function actionSource( $date = '' ){
		$date = $date?$date:date("Y-m-d");
		if( !preg_match("/^\d{4}-\d{2}-\d{2}$/",$date) ){
			return $this->echoLog("param date format error,2016-04-28");
		}

		$time_from = date("Y-m-d 00:00:00",strtotime( $date ) );
		$time_to = date("Y-m-d 23:59:59",strtotime( $date ) );

		$list = AccessLogs::find()
			->select([ 'source','COUNT(*) as total_number' ])
			->where([ '>=','created_time',$time_from ])
			->andWhere([ '<=','created_time',$time_to ])
			->asArray()
			->all();

		if( !$list ){
			return $this->echoLog('no data to handle~~');
		}

		$date_int = date("Ymd",strtotime( $date ) );
		$date_now = date("Y-m-d H:i:s");
		foreach( $list as $_item ){
			$tmp_source = $_item['source'];
			$tmp_total_number = $_item['total_number'];
			$tmp_info = StatDailyAccessSource::find()
				->where([ 'date' => $date_int,'source' => $tmp_source ])
				->one();
			if( $tmp_info ){
				$tmp_model_info = $tmp_info;
			}else{
				$tmp_model_info = new StatDailyAccessSource();
				$tmp_model_info->date = $date_int;
				$tmp_model_info->source = $tmp_source;
			}
			$tmp_model_info->total_number = $tmp_total_number;
			$tmp_model_info->created_time = $date_now;
			$tmp_model_info->save(0);
		}

	}
}