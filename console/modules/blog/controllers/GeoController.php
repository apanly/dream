<?php

namespace console\modules\blog\controllers;

use common\models\posts\RichMedia;
use common\service\GeoService;
use console\modules\blog\Blog;

class GeoController extends Blog{
    public function actionAddress(){
        $rich_media_list = RichMedia::find()->orderBy("id asc")->all();
        if( !$rich_media_list ){
            return;
        }
        foreach( $rich_media_list as $_item ){
            if( !$_item['gps'] ){
                continue;
            }

            $gps_info = @json_decode( strtolower($_item['gps']),true);
            if( !$gps_info ){
                continue;
            }
            $lat = $gps_info['latitude'];
            $lng = $gps_info['longitude'];
            $address = GeoService::baidugeocoding($lat,$lng);
            if( !$address ){
                continue;
            }
            $_item->address = $address;
            $_item->update(0);
        }
    }
}