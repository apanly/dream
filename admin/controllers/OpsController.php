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
use common\service\GlobalUrlService;
use common\service\ipip\IPService;
use Yii;


class OpsController extends BaseController{

	public function actionIndex(){
		return $this->render("index");
	}
    private $log_type_mapping = [
        1 => 'app-blog',
        2 => 'app-js',
		3 => 'app-console'
    ];

    public function actionError(){
        $type = intval( $this->get("type",0) );
        $log_type_mapping = $this->log_type_mapping;

        $p = intval( $this->get("p",1) );
        if(!$p){
            $p = 1;
        }

        $data = [];
        $query = AppLogs::find();

        if( isset( $log_type_mapping[ $type ] ) ){
            $query->andWhere([ 'app_name' =>  $log_type_mapping[ $type ] ]);
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
                $data[] = [
                    'idx' =>  $idx,
                    'app_name' => $_item_access['app_name'],
                    'request_uri' => $_item_access['request_uri'],
                    'content' => ( mb_strlen($_item_access['content'],"utf-8") > 150)?  DataHelper::encode( mb_substr($_item_access['content'],0,150,"utf-8") ):DataHelper::encode( $_item_access['content'] ),
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

        return $this->render("error",[
            "data" => $data,
            "page_info" => $page_info,
            'search_conditions' => $search_conditions,
            'log_type_mapping' => $log_type_mapping
        ]);
    }

}