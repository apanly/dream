<?php

namespace admin\controllers;

use admin\components\AdminUrlService;
use admin\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\library\Book;
use common\models\posts\Posts;
use common\models\stat\StatAccess;
use common\models\stat\StatBlog;
use common\models\stat\StatDailyAccessSource;
use common\models\stat\StatDailyBrowser;
use common\models\stat\StatDailyDevice;
use common\models\stat\StatDailyOs;
use common\service\GeoService;
use common\service\GlobalUrlService;
use Yii;


class ChartsController extends BaseController {
    public function actionDashboard(){
		$date_from = $this->get("date_from", date("Y-m-d") );
		$date_to = $this->get("date_to", date("Y-m-d") );

        $date_from_int = date("Ymd",strtotime( $date_from ) );
        $date_to_int = date("Ymd",strtotime( $date_to ) );
        /*今日来源域名*/
        $ignore_source = ["direct","www.vincentguo.cn","m.vincentguo.cn" ];
        $data_source = [
			'series' => [
				[
					'data' => []
				]
			]
		];
		$source_list = StatDailyAccessSource::find()
			->select([ 'source','SUM(total_number) as total_number' ])
			->where([ 'between','date' , $date_from_int,$date_to_int ])
			->andWhere([ 'not in','source',$ignore_source ])
			->orderBy([ 'total_number' => SORT_DESC ])
			->groupBy([ 'source' ])
			->asArray()
			->all();
		if( $source_list ){
			$total_number = array_sum(  array_column($source_list,"total_number") );
			foreach( $source_list as $_item ){
				$data_source['series'][0]['data'][] =[
					'name' => $_item['source'],
					'y' => floatval( sprintf("%.2f", ( $_item['total_number']/ $total_number) * 100 ) ),
					'total_number' => $_item['total_number']
				];
			}
		}
		/*操作系统*/
		$data_client_os = [
			'series' => [
				[
					'data' => []
				]
			]
		];
		$os_list = StatDailyOs::find()
			->select([ 'client_os','SUM(total_number) as total_number' ])
			->where([ 'between','date' , $date_from_int,$date_to_int ])
			->orderBy([ 'total_number' => SORT_DESC ])
			->groupBy([ 'client_os' ])
			->asArray()
			->all();
		if( $os_list ){
			$total_number = array_sum(  array_column($os_list,"total_number") );
			foreach( $os_list as $_item ){
				$data_client_os['series'][0]['data'][] =[
					'name' => $_item['client_os'],
					'y' => floatval( sprintf("%.2f", ( $_item['total_number']/ $total_number) * 100 ) ),
					'total_number' => $_item['total_number']
				];
			}
		}

		/*浏览器统计*/
		$data_client_browser = [
			'series' => [
				[
					'data' => []
				]
			]
		];

		$client_browser_list = StatDailyBrowser::find()
			->select([ 'client_browser','SUM(total_number) as total_number' ])
			->where([ 'between','date' , $date_from_int,$date_to_int ])
			->orderBy([ 'total_number' => SORT_DESC ])
			->groupBy([ 'client_browser' ])
			->asArray()
			->all();
		if( $client_browser_list ){
			$total_number = array_sum(  array_column($client_browser_list,"total_number") );
			foreach( $client_browser_list as $_item ){
				$data_client_browser['series'][0]['data'][] =[
					'name' => $_item['client_browser'],
					'y' => floatval( sprintf("%.2f", ( $_item['total_number']/ $total_number) * 100 ) ),
					'total_number' => $_item['total_number']
				];
			}
		}

		/*设备统计*/
		$data_client_device = [
			'series' => [
				[
					'data' => []
				]
			]
		];

		$client_device_list = StatDailyDevice::find()
			->select([ 'client_device','SUM(total_number) as total_number' ])
			->where([ 'between','date' , $date_from_int,$date_to_int ])
			->orderBy([ 'total_number' => SORT_DESC ])
			->groupBy([ 'client_device' ])
			->asArray()
			->all();
		if( $client_device_list ){
			$total_number = array_sum(  array_column($client_device_list,"total_number") );
			foreach( $client_device_list as $_item ){
				$data_client_device['series'][0]['data'][] =[
					'name' => $_item['client_device'],
					'y' => floatval( sprintf("%.2f", ( $_item['total_number']/ $total_number) * 100 ) ),
					'total_number' => $_item['total_number']
				];
			}
		}

        return $this->renderJSON([
			'client_os' => $data_client_os,
			'source' => $data_source,
			'client_browser' => $data_client_browser,
			'client_device' => $data_client_device,
		]);
    }
}