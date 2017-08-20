<?php

namespace console\modules\market\controllers;

use common\components\HttpClient;
use common\models\soft\Soft;
use console\controllers\BaseController;

require_once __DIR__."/../../../../common/service/dom/simple_html_dom.php";


class MinaController extends BaseController {

	//http://www.lanrenmb.com/x/p17.html
	//php yii market/mina/index
    public function actionIndex(){
		$total = 17 ;
		for( $i = $total;$i > 0;$i-- ){
			$url = "http://www.lanrenmb.com/x/p{$i}.html";
			HttpClient::setGzip();
			$tmp_data = HttpClient::get( $url );
			if( !mb_check_encoding( $tmp_data , 'utf-8') ) {
				$tmp_data = mb_convert_encoding($tmp_data,'UTF-8','gbk');
			}
			$this->scrapyList( $tmp_data );
			sleep( 1 );
		}
    }

    //php yii market/mina/info
    public function actionInfo(){
    	$i = 0;

    	$list = Soft::find()->orderBy([ 'id' => SORT_ASC ])->all();
		HttpClient::setCookie( "PHPSESSID=251qgrmmde0sv8e1kf2ekketq0" );
    	foreach ( $list as $_item  ){
			$tmp_info_url = $_item['origin_info_url'];
			$tmp_pos = strripos( $tmp_info_url,"/" );
			$tmp_id = substr($tmp_info_url, $tmp_pos + 1 );
			$tmp_id = str_replace( ".html","",$tmp_id );
			$tmp_target_url = "http://www.lanrenmb.com/User/index.php/User/downLoad.html?type=downLoad&aid={$tmp_id}&url=".urlencode( $tmp_info_url );
			$tmp_data = HttpClient::get( $tmp_target_url,[] );
			$tmp_path = "/home/www/downloads/{$_item['id']}_{$_item['sn']}.zip";
			file_put_contents( $tmp_path,$tmp_data );
			sleep( 1 );
		}
	}

    private function scrapyList( $data ){
		$target_html = str_get_html( $data );
		foreach( $target_html->find(".list-qq dl dd") as $_element ) {
			$tmp_name = $_element->plaintext;
			$tmp_inner_text =  $_element->innertext;
			$tmp_html_target = str_get_html( $tmp_inner_text );
			$tmp_preview = $tmp_html_target->find("a.preview");
			$tmp_img = $tmp_html_target->find("img");

			$tmp_data = [
				'title' => $tmp_name,
				'type' => 1,
				'img_url' =>  "http://www.lanrenmb.com".trim( $tmp_img[0]->attr['src'] ),
				'info_url' => "http://www.lanrenmb.com".trim( $tmp_preview[0]->attr['href'] )
			];

			$this->insertSoft( $tmp_data );
		}
	}
}
