<?php

namespace console\modules\blog\controllers;

use common\models\applog\AdCspReport;
use console\modules\blog\Blog;


class DefaultController extends Blog{
    public function actionIndex(){

    }

    public function actionCsp(){
		$list = AdCspReport::find()->orderBy([ 'id' => SORT_ASC ])->all();
		$data = [];
		foreach( $list as $_item ){
			$tmp_content = @json_decode( $_item['report_content'],true );

			if( !$tmp_content || !isset($tmp_content['csp-report']) || !isset( $tmp_content['csp-report']['blocked-uri'] ) ){
				continue;
			}

			$tmp_blocked_uri = $tmp_content['csp-report']['blocked-uri'];
			$tmp_blocked_uri = parse_url( $tmp_blocked_uri );
			if( !isset($tmp_blocked_uri['host'])  ){
				continue;
			}
			$tmp_port = isset( $tmp_blocked_uri['port'] )?$tmp_blocked_uri['port']:'';
			$tmp_blocked_uri = $tmp_blocked_uri['host'];
			if( $tmp_port ){
				$tmp_blocked_uri .= ":{$tmp_port}";
			}

			$_item->blocked_uri = $tmp_blocked_uri;
			if( isset( $tmp_content['csp-report']['source-file'] ) ){
				$_item->source_file = $tmp_content['csp-report']['source-file'];
			}
			$_item->update(0);



			if( !isset( $data[ $tmp_blocked_uri ] ) ){
				$data[ $tmp_blocked_uri  ] = 0;
			}
			$data[ $tmp_blocked_uri  ]++;
		}
		asort( $data,SORT_NUMERIC );
		unset( $list );
		foreach( $data as $_domain => $_counter ){
			echo $_counter."	".$_domain."\r\n";
		}
	}
}