<?php

namespace admin\controllers;

use admin\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\applog\AccessLogs;
use common\models\applog\AdCspReport;
use common\models\applog\AppLogs;
use common\models\stat\StatDailyAccessSource;
use common\models\stat\StatDailyBrowser;
use common\models\stat\StatDailyOs;
use common\models\stat\StatDailyUuid;
use common\models\weixin\WxHistory;
use common\service\GlobalUrlService;
use common\service\ipip\IPService;
use Yii;


class LogController extends BaseController{
    public function actionAccess(){
		$date_from = $this->get("date_from",date("Y-m-01") );
		$date_to = $this->get("date_to",date("Y-m-d") );
		$source = trim( $this->get("source","") );
		$uuid = trim( $this->get("uuid",""));
		$client_os = trim( $this->get("client_os",""));
		$client_browser = trim( $this->get("client_browser",""));
        $p = intval( $this->get("p",1) );
        if(!$p){
            $p = 1;
        }

        $data = [];
        $query = AccessLogs::find();
		if( $date_from ){
			$query->andWhere([ '>=','created_time',$date_from.' 00:00:00' ]);
		}
		if( $date_from ){
			$query->andWhere([ '<=','created_time',$date_to." 23:59:59" ]);
		}

		if( $source ){
			$query->andWhere([ 'source' => $source ]);
		}

		if( $uuid ){
			$query->andWhere([ 'uuid' => $uuid ]);
		}

		if( $client_os ){
			$query->andWhere([ 'client_os' => $client_os ]);
		}

		if( $client_browser ){
			$query->andWhere([ 'client_browser' => $client_browser ]);
		}

        $total_count = $query->count();
        $offset = ($p - 1) * $this->page_size;
        $access_list = $query->orderBy("id desc")
            ->offset($offset)
            ->limit( $this->page_size )
            ->all();

        $page_info = DataHelper::ipagination([
            "total_count" => $total_count,
            "page_size" => $this->page_size,
            "page" => $p,
            "display" => 10
        ]);

        if($access_list){
            $idx = 1;
            foreach($access_list as $_item_access ){
                $tmp_referer = urldecode($_item_access['referer']);
                if( stripos($tmp_referer,"baidu.com") !== false ){
                    $tmp_referer = @iconv("GBK","UTF-8",$tmp_referer);
                }

                $data[] = [
                    'idx' =>  $idx,
                    'target_url' => urldecode($_item_access['target_url']),
                    'referer' => $tmp_referer,
                    'user_agent' => $_item_access['user_agent'],
                    'source' => $_item_access['source'],
                    'uuid' => $_item_access['uuid'],
                    'ip' => $_item_access['ip'],
                    'ip_desc' => implode(" ",IPService::find($_item_access['ip']) ),
                    'browser' => $_item_access['client_browser']."/".$_item_access['client_browser_version'],
                    'os' => $_item_access['client_os']."/".$_item_access['client_os_version'],
					'client_device' => $_item_access['client_device'],
                    'created_time' => $_item_access['created_time']
                ];
                $idx++;
            }
        }

		$search_conditions = [
			'date_from' => $date_from,
			'date_to' => $date_to,
			'source' => $source,
			'uuid' => $uuid,
			'client_os' => $client_os,
			'client_browser' => $client_browser
		];

        return $this->render("access",[
            "data" => $data,
            "page_info" => $page_info,
            'search_conditions' => $search_conditions
        ]);
    }

    public function actionUuid(){
    	$date_from = $this->get("date_from",date("Y-m-d") );
    	$date_to = $this->get("date_to",date("Y-m-d") );

		$p = intval( $this->get("p",1) );
		if(!$p){
			$p = 1;
		}


		$query = StatDailyUuid::find();
		if( $date_from ){
			$query->andWhere([ '>=','date',date("Ymd",strtotime( $date_from ) ) ]);
		}
		if( $date_from ){
			$query->andWhere([ '<=','date',date("Ymd",strtotime( $date_to ) ) ]);
		}

		$total_count = $query->count();
		$offset = ($p - 1) * $this->page_size;
		$list = $query->orderBy("id desc")->offset($offset)->limit( $this->page_size )->all();

		$page_info = DataHelper::ipagination([
			"total_count" => $total_count,
			"page_size" => $this->page_size,
			"page" => $p,
			"display" => 10
		]);
		$data = [];
		if($list){
			$idx = 1;
			foreach($list as $_item ){

				$data[] = [
					'idx' =>  $idx,
					'date' => $_item['date'],
					'uuid' => $_item['uuid'],
					'total_number' => $_item['total_number']
				];
				$idx++;
			}
		}

		$search_conditions = [
			'date_from' => $date_from,
			'date_to' => $date_to,
		];
		return $this->render("uuid",[
			"data" => $data,
			"page_info" => $page_info,
			'search_conditions' => $search_conditions
		]);
	}

	public function actionSource(){
		$date_from = $this->get("date_from",date("Y-m-d") );
		$date_to = $this->get("date_to",date("Y-m-d") );

		$p = intval( $this->get("p",1) );
		if(!$p){
			$p = 1;
		}


		$query = StatDailyAccessSource::find();
		if( $date_from ){
			$query->andWhere([ '>=','date',date("Ymd",strtotime( $date_from ) ) ]);
		}
		if( $date_from ){
			$query->andWhere([ '<=','date',date("Ymd",strtotime( $date_to ) ) ]);
		}

		$total_count = $query->count();
		$offset = ($p - 1) * $this->page_size;
		$list = $query->orderBy("id desc")->offset($offset)->limit( $this->page_size )->all();

		$page_info = DataHelper::ipagination([
			"total_count" => $total_count,
			"page_size" => $this->page_size,
			"page" => $p,
			"display" => 10
		]);
		$data = [];
		if($list){
			$idx = 1;
			foreach($list as $_item ){

				$data[] = [
					'idx' =>  $idx,
					'date' => $_item['date'],
					'source' => $_item['source'],
					'total_number' => $_item['total_number']
				];
				$idx++;
			}
		}

		$search_conditions = [
			'date_from' => $date_from,
			'date_to' => $date_to,
		];
		return $this->render("source",[
			"data" => $data,
			"page_info" => $page_info,
			'search_conditions' => $search_conditions
		]);
	}

	public function actionOs(){
		$date_from = $this->get("date_from",date("Y-m-d") );
		$date_to = $this->get("date_to",date("Y-m-d") );

		$p = intval( $this->get("p",1) );
		if(!$p){
			$p = 1;
		}


		$query = StatDailyOs::find();
		if( $date_from ){
			$query->andWhere([ '>=','date',date("Ymd",strtotime( $date_from ) ) ]);
		}
		if( $date_from ){
			$query->andWhere([ '<=','date',date("Ymd",strtotime( $date_to ) ) ]);
		}

		$total_count = $query->count();
		$offset = ($p - 1) * $this->page_size;
		$list = $query->orderBy([ 'id' => SORT_DESC ])->offset($offset)->limit( $this->page_size )->all();

		$page_info = DataHelper::ipagination([
			"total_count" => $total_count,
			"page_size" => $this->page_size,
			"page" => $p,
			"display" => 10
		]);
		$data = [];
		if($list){
			$idx = 1;
			foreach($list as $_item ){
				$data[] = [
					'idx' =>  $idx,
					'date' => $_item['date'],
					'client_os' => $_item['client_os'],
					'total_number' => $_item['total_number']
				];
				$idx++;
			}
		}

		$search_conditions = [
			'date_from' => $date_from,
			'date_to' => $date_to,
		];
		return $this->render("os",[
			"data" => $data,
			"page_info" => $page_info,
			'search_conditions' => $search_conditions
		]);
	}

	public function actionBrowser(){
		$date_from = $this->get("date_from",date("Y-m-d") );
		$date_to = $this->get("date_to",date("Y-m-d") );

		$p = intval( $this->get("p",1) );
		if(!$p){
			$p = 1;
		}


		$query = StatDailyBrowser::find();
		if( $date_from ){
			$query->andWhere([ '>=','date',date("Ymd",strtotime( $date_from ) ) ]);
		}
		if( $date_from ){
			$query->andWhere([ '<=','date',date("Ymd",strtotime( $date_to ) ) ]);
		}

		$total_count = $query->count();
		$offset = ($p - 1) * $this->page_size;
		$list = $query->orderBy([ 'id' => SORT_DESC ])->offset($offset)->limit( $this->page_size )->all();

		$page_info = DataHelper::ipagination([
			"total_count" => $total_count,
			"page_size" => $this->page_size,
			"page" => $p,
			"display" => 10
		]);
		$data = [];
		if($list){
			$idx = 1;
			foreach($list as $_item ){
				$data[] = [
					'idx' =>  $idx,
					'date' => $_item['date'],
					'client_browser' => $_item['client_browser'],
					'total_number' => $_item['total_number']
				];
				$idx++;
			}
		}

		$search_conditions = [
			'date_from' => $date_from,
			'date_to' => $date_to,
		];
		return $this->render("browser",[
			"data" => $data,
			"page_info" => $page_info,
			'search_conditions' => $search_conditions
		]);
	}

	public function actionCsp(){
		$date_from = $this->get("date_from",date("Y-m-d") );
		$date_to = $this->get("date_to",date("Y-m-d") );

		$p = intval( $this->get("p",1) );
		if(!$p){
			$p = 1;
		}

		$query = AdCspReport::find();
		if( $date_from ){
			$query->andWhere([ '>=','created_time',date("Y-m-d",strtotime( $date_from ) ) ]);
		}
		if( $date_from ){
			$query->andWhere([ '<=','created_time',date("Y-m-d 23:59:59",strtotime( $date_to ) ) ]);
		}

		$total_count = $query->count();
		$offset = ($p - 1) * $this->page_size;
		$list = $query->orderBy([ 'id' => SORT_DESC ])->offset($offset)->limit( $this->page_size )->all();

		$page_info = DataHelper::ipagination([
			"total_count" => $total_count,
			"page_size" => $this->page_size,
			"page" => $p,
			"display" => 10
		]);
		$data = [];
		if($list){
			$idx = 1;
			foreach($list as $_item ){
				$data[] = [
					'idx' =>  $idx,
					'created_time' => $_item['created_time'],
					'blocked_uri' => $_item['blocked_uri'],
					'source_file' => $_item['source_file']
				];
				$idx++;
			}
		}

		$search_conditions = [
			'date_from' => $date_from,
			'date_to' => $date_to,
		];
		return $this->render("csp",[
			"data" => $data,
			"page_info" => $page_info,
			'search_conditions' => $search_conditions
		]);
	}

	public function actionWechat(){
		$p = intval( $this->get("p",1) );
		if(!$p){
			$p = 1;
		}
		$query = WxHistory::find();
		$total_count = $query->count();
		$offset = ($p - 1) * $this->page_size;
		$list = $query->orderBy([ 'id' => SORT_DESC ] )
			->offset($offset)->limit( $this->page_size )
			->all();

		$page_info = DataHelper::ipagination([
			"total_count" => $total_count,
			"page_size" => $this->page_size,
			"page" => $p,
			"display" => 10
		]);

		$data = [];
		if( $list ){
			foreach( $list as $_item ){
				$data[] = [
					'id' => $_item['id'],
					'openid' => $_item['from_openid'],
					'type' => $_item['type'],
					'content' => $_item['content'],
					'text' => $_item['text'],
				];
			}
		}

		return $this->render("wechat",[
			"data" => $data,
			"page_info" => $page_info,
			'search_conditions' => []
		]);
	}

}