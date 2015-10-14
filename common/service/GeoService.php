<?php

namespace common\service;


use common\components\HttpLib;

class GeoService {

    public static function baidugeocoding($lat,$lng){
        $ak = "DXSmX4CZ4NIeDVijxgMiGPC7";
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
} 