<?php
namespace console\modules\report\controllers;


use common\models\applog\AccessLogs;
use common\models\applog\StatDailyAccessSource;
use common\models\applog\StatDailyUuid;
use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Os;
use Sinergi\BrowserDetector\Device;

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
			->groupBy("source")
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

		return $this->echoLog("it's over~~");
	}

	/*
	 * php yii report/stat_daily/uuid
	 * */
	public function actionUuid( $date = '' ){
		$date = $date?$date:date("Y-m-d");
		if( !preg_match("/^\d{4}-\d{2}-\d{2}$/",$date) ){
			return $this->echoLog("param date format error,2016-04-28");
		}

		$time_from = date("Y-m-d 00:00:00",strtotime( $date ) );
		$time_to = date("Y-m-d 23:59:59",strtotime( $date ) );

		$list = AccessLogs::find()
			->select([ 'uuid','COUNT(*) as total_number' ])
			->where([ '>=','created_time',$time_from ])
			->andWhere([ '<=','created_time',$time_to ])
			->groupBy("uuid")
			->asArray()
			->all();

		if( !$list ){
			return $this->echoLog('no data to handle~~');
		}

		$date_int = date("Ymd",strtotime( $date ) );
		$date_now = date("Y-m-d H:i:s");
		foreach( $list as $_item ){
			$tmp_uuid = $_item['uuid'];
			if( !$tmp_uuid ){
				continue;
			}
			$tmp_total_number = $_item['total_number'];
			$tmp_info = StatDailyUuid::find()
				->where([ 'date' => $date_int,'uuid' => $tmp_uuid ])
				->one();
			if( $tmp_info ){
				$tmp_model_info = $tmp_info;
			}else{
				$tmp_model_info = new StatDailyUuid();
				$tmp_model_info->date = $date_int;
				$tmp_model_info->uuid = $tmp_uuid;
			}
			$tmp_model_info->total_number = $tmp_total_number;
			$tmp_model_info->created_time = $date_now;
			$tmp_model_info->save(0);
		}

		return $this->echoLog("it's over~~");
	}

	public function actionTest(){
		$list = AccessLogs::find()->orderBy([ 'id' => SORT_ASC ])->all();
		foreach( $list as $_item ){
			$tmp_browser = new Browser( $_item['user_agent'] );
			$tmp_os = new Os( $_item['user_agent'] );
			$tmp_device = new Device( $_item['user_agent'] );
			$_item->client_browser = $tmp_browser;
			$_item->client_os = $tmp_os;
			$_item->client_device = $tmp_device;
			$_item->update(0);
		}
	}
}