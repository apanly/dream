<?php

namespace common\service;


use common\components\HttpClient;
use common\components\HttpLib;

class GeoService {

    public static function baidugeocoding($lat,$lng){
        $ak = self::getAK();
        $url = "http://api.map.baidu.com/geocoder/v2/?ak={$ak}&location={$lat},{$lng}&output=json&pois=0&coordtype=wgs84ll";
        $http_target = new HttpLib();
        $ret = $http_target->get($url);
        if( $ret['response']['code'] != 200 ){
            return false;
        }
        $data = json_decode( $ret['body'],true);
        if( $data['status'] != 0 ){
            return false;
        }
        $geo_info = $data['result'];

        return $geo_info['formatted_address'];
    }

    /*
     * 文档地址：http://lbsyun.baidu.com/index.php?title=webapi/high-acc-ip
     *
     */

    public static function getGeoByIP( $ip ){
		$ak = self::getAK();
		$url = "https://api.map.baidu.com/highacciploc/v1?qcip={$ip}&qterm=pc&ak={$ak}&coord=bd09ll";
		var_dump( HttpClient::get( $url ) );
	}

	private static function getAK(){
    	return \Yii::$app->params['geo']['baidu']['ak'];
	}

} 