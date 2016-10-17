<?php

namespace admin\controllers;

use admin\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\applog\AccessLogs;
use common\models\applog\AppLogs;
use common\models\applog\StatDailyAccessSource;
use common\models\applog\StatDailyUuid;
use common\service\GlobalUrlService;
use Yii;


class LogController extends BaseController{
	private $page_size = 20;
    public function actionAccess(){
		$date_from = $this->get("date_from",date("Y-m-01") );
		$date_to = $this->get("date_to",date("Y-m-d") );
		$source = trim( $this->get("source","") );
		$uuid = trim( $this->get("uuid",""));
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

        $total_count = $query->count();
        $offset = ($p - 1) * $this->page_size;
        $access_list = $query->orderBy("id desc")
            ->offset($offset)
            ->limit( $this->page_size )
            ->all();

        $page_info = DataHelper::ipagination([
            "total_count" => $total_count,
            "pagesize" => $this->page_size,
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
                    'created_time' => $_item_access['created_time']
                ];
                $idx++;
            }
        }

		$search_conditions = [
			'date_from' => $date_from,
			'date_to' => $date_to,
			'source' => $source,
			'uuid' => $uuid
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
			"pagesize" => $this->page_size,
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
			"pagesize" => $this->page_size,
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

    private $log_type_mapping = [
        1 => 'app-blog',
        2 => 'app-js'
    ];

    public function actionApp(){
        $type = intval( $this->get("type",0) );
        $log_type_mapping = $this->log_type_mapping;

        $p = intval( $this->get("p",1) );
        if(!$p){
            $p = 1;
        }

        $data = [];
        $pagesize = 20;
        $query = AppLogs::find();

        if( isset( $log_type_mapping[ $type ] ) ){
            $query->andWhere([ 'app_name' =>  $log_type_mapping[ $type ] ]);
        }

        $total_count = $query->count();
        $offset = ($p - 1) * $pagesize;
        $access_list = $query->orderBy("id desc")
            ->offset($offset)
            ->limit($pagesize)
            ->all();

        $page_info = DataHelper::ipagination([
            "total_count" => $total_count,
            "pagesize" => $pagesize,
            "page" => $p,
            "display" => 10
        ]);

        if($access_list){
            $idx = 1;
            foreach($access_list as $_item_access ){

                $data[] = [
                    'idx' =>  $idx,
                    'app_name' => $_item_access['app_name'],
                    'request_uri' => $_item_access['request_uri'],
                    'content' => DataHelper::encode( $_item_access['content'] ),
                    'ua' => $_item_access['ua'],
                    'ip' => $_item_access['ip'],
                    'cookies' => DataHelper::encode( $_item_access['cookies']),
                    'created_time' => $_item_access['created_time']
                ];
                $idx++;
            }
        }

        $search_conditions = [
            'type' => $type
        ];
        return $this->render("app",[
            "data" => $data,
            "page_info" => $page_info,
            "page_url" => "/log/app",
            'search_conditions' => $search_conditions,
            'log_type_mapping' => $log_type_mapping
        ]);
    }

}