<?php

namespace admin\controllers;

use admin\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\applog\AccessLogs;
use common\models\applog\AppLogs;
use common\service\GlobalUrlService;
use Yii;


class LogController extends BaseController{
    public function actionAccess(){
        $p = intval( $this->get("p",1) );
        if(!$p){
            $p = 1;
        }

        $data = [];
        $pagesize = 20;
        $query = AccessLogs::find();
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
                    'target_url' => $_item_access['target_url'],
                    'referer' => $_item_access['referer'],
                    'user_agent' => $_item_access['user_agent'],
                    'ip' => $_item_access['ip'],
                    'created_time' => $_item_access['created_time']
                ];
                $idx++;
            }
        }
        return $this->render("access",[
            "data" => $data,
            "page_info" => $page_info,
            "page_url" => "/log/access"
        ]);
    }

    public function actionApp(){
        $p = intval( $this->get("p",1) );
        if(!$p){
            $p = 1;
        }

        $data = [];
        $pagesize = 20;
        $query = AppLogs::find();
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
                    'content' => $_item_access['content'],
                    'ua' => $_item_access['ua'],
                    'ip' => $_item_access['ip'],
                    'cookies' => $_item_access['cookies'],
                    'created_time' => $_item_access['created_time']
                ];
                $idx++;
            }
        }
        return $this->render("app",[
            "data" => $data,
            "page_info" => $page_info,
            "page_url" => "/log/access"
        ]);
    }

}