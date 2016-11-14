<?php
namespace console\modules\report\controllers;


use common\components\HttpClient;
use common\models\geo\MapCity;

class GrabController extends Stat_utilController{

	/**
	 * http://www.mca.gov.cn/article/sj/tjbz/a/2016/20161031/201610311102.html
	 * http://www.stats.gov.cn/tjsj/tjbz/xzqhdm/201608/t20160809_1386477.html
	 * 抓取省市区，抓取之后的数据结构如下
	 * [
	 * 		'province_id' => [
	 * 			'id' => '',
	 * 			'name' = >'',
	 * 			'city_list' => [
	 * 				'city_id' => [
	 * 					'id' => '',
	 * 					'name' => ''
	 * 				]
	 * 			],
	 * 			'district_list' => [
	 * 				'city_id' => [
* 						'district_id' => [
	 * 						'id' => '',
	 * 						'name' => ''
	 * 					]
	 * 				]
	 * 			]
	 * 		]
	 * ]
	 * php yii report/grab/mac
	 *
	 */
	public function actionMca(){
		$url = "http://www.stats.gov.cn/tjsj/tjbz/xzqhdm/201608/t20160809_1386477.html";
		$content = HttpClient::get( $url );
		$html_dom = new \HtmlParser\ParserDom($content);
		$target = $html_dom->find('p.MsoNormal');
		if( !$target){
			return $this->echoLog("error:no table tag ~~");
		}

		$ret = [];
		foreach(  $target as $_item_target ){
			$tmp_td_array = $_item_target->find("span");
			if( !$tmp_td_array || count( $tmp_td_array ) < 3 ){
				continue;
			}

			$tmp_id = $tmp_td_array[0]->getPlainText();
			$tmp_title = trim( $tmp_td_array[2]->getPlainText() );
			$tmp_title = strip_tags($tmp_title);
			$tmp_title = trim($tmp_title,"    ");
			//$this->echoLog($tmp_id.":".$tmp_title);

			if( substr($tmp_id,2,4) == "0000" ){//省
				$ret[ $tmp_id ] = [
					'id' => $tmp_id,
					'name' => $tmp_title,
					'city_list' => [],
					'district_list' => []
				];
				continue;
			}

			if( substr($tmp_id,4,2) == "00" ){//市
				$tmp_province_id = substr($tmp_id,0,2)."0000";
				if( !isset($ret[ $tmp_province_id ] ) ){
					$this->echoLog("error");
					exit();
				}
				$ret[ $tmp_province_id ]['city_list'][ $tmp_id ] = [
					'id' => $tmp_id,
					'name' => $tmp_title
				] ;
				continue;
			}
			//区
			$tmp_province_id = substr($tmp_id,0,2)."0000";
			$tmp_city_id = substr($tmp_id,0,4)."00";
			if( !isset($ret[ $tmp_province_id ] ) ){
				$this->echoLog("error");
				exit();
			}
			//这种情况就是直辖市，自己新生成一个市
			if( !isset($ret[ $tmp_province_id ]['city_list'][$tmp_city_id] ) ){
				$ret[ $tmp_province_id ]['city_list'][ $tmp_city_id ] = [
					'id' => $tmp_city_id,
					'name' => $ret[ $tmp_province_id ]['name']
				] ;
			}

			$ret[ $tmp_province_id ]['district_list'][$tmp_city_id][ $tmp_id ] = [
				'id' => $tmp_id,
				'name' => $tmp_title
			] ;

		}


		foreach( $ret as $_item ){
			$tmp_province_id = $_item['id'];
			$tmp_province_name = $_item['name'];
			$tmp_params = [
				'id' => $tmp_province_id,
				'province_id' => $tmp_province_id,
				'province_name' => $tmp_province_name
			];
			$this->setMapCityItem( $tmp_params  );
			if( !$_item['city_list'] ){
				continue;
			}
			foreach( $_item['city_list'] as $_city_id => $_city_info ){
				$tmp_params = [
					'id' => $_city_id,
					'province_id' => $tmp_province_id,
					'province_name' => $tmp_province_name,
					'city_id' => $_city_id,
					'city_name' => $_city_info['name']
				];
				$this->setMapCityItem( $tmp_params  );
				if( !$_item['district_list'] || !isset( $_item['district_list'][ $_city_id ] ) ){
					continue;
				}
				$tmp_district_list = $_item['district_list'][ $_city_id ];
				foreach(  $tmp_district_list as  $_district_info ){
					$tmp_params = [
						'id' => $_district_info['id'],
						'province_id' => $tmp_province_id,
						'province_name' => $tmp_province_name,
						'city_id' => $_city_id,
						'city_name' => $_city_info['name'],
						'district_id' => $_district_info['id'],
						'district_name' => $_district_info['name']
					];
					$this->setMapCityItem( $tmp_params  );
				}
			}
		}
	}

	private function setMapCityItem( $params ){
		$date_now = date("Y-m-d H:i:s");
		$info = MapCity::find()->where([ 'id' => $params['id'] ])->one();
		if( $info ){
			$model_info = $info;
		}else{
			$model_info = new MapCity();
			$model_info->id = $params['id'];
			$model_info->created_time = $date_now;
		}
		$model_info->province_id = isset( $params['province_id'] )?$params['province_id']:0;
		$model_info->province_name = isset( $params['province_name'] )?$params['province_name']:'';
		$model_info->city_id = isset( $params['city_id'] )?$params['city_id']:0;
		$model_info->city_name = isset( $params['city_name'] )?$params['city_name']:'';
		$model_info->district_id = isset( $params['district_id'] )?$params['district_id']:0;
		$model_info->district_name = isset( $params['district_name'] )?$params['district_name']:'';
		$model_info->updated_time = $date_now;
		$model_info->save( 0 );
	}
}