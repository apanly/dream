<?php
/**
 * Created by PhpStorm.
 * User: hujie
 * Date: 2015/4/8
 * Time: 19:57
 */

namespace common\service;


use common\components\ip\IPQuery;
use common\components\UtilHelper;
use common\models\data\City;
use common\components\DataHelper;

class CityService {

    public static function getFullAddressByCode($code,$separator = ','){
        $code = intval($code);
        $record = City::findOne($code);
        if(!$record)
        {
            return '';
        }
        $return = $record->province;
        if($record->city)
        {
            $return .= $separator.$record->city;
        }
        if($record->area)
        {
            $return .= $separator.$record->area;
        }
        return $return;
    }

    public static function getCityIdByIP($ip){
        $city_by_ip = IPQuery::find($ip);
        if(is_array($city_by_ip)) {
            $cityname = '';
            while( !$cityname && !empty($city_by_ip) ) {
                $cityname = array_pop($city_by_ip);
            }
            if($cityname) {
                $city = City::find()->where(['LIKE','name',$cityname.'%',false])->one();
            }
        }

        if( !empty($city) ) {
            return $city->id;
        }
        return 0;
    }

	public static function getCityNameByIp($ip='')
	{
		if(!$ip)
		{
			$ip = UtilHelper::getClientIP();
		}
		$city_info = IPQuery::find($ip);
		if(is_array($city_info))
		{
			$city_info = array_reverse($city_info);
			foreach($city_info as $_city)
			{
				if($_city)
				{
					return $_city;
				}
			}
		}
		elseif(is_string($city_info))
		{
			return $city_info;
		}
		return '';
	}
}