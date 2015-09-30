<?php

namespace admin\controllers;

use admin\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\games\Doubanmz;
use Yii;


class DoubanController extends BaseController
{

    public function actionMz(){
        $p = intval( $this->get("p",1) );
        if(!$p){
            $p = 1;
        }


        $pagesize = 20;

        $query = Doubanmz::find();
        $total_count = $query->count();
        $offset = ($p - 1) * $pagesize;
        $mz_list = $query->orderBy("id desc")
            ->offset($offset)
            ->limit($pagesize)
            ->all();

        $page_info = DataHelper::ipagination([
            "total_count" => $total_count,
            "pagesize" => $pagesize,
            "page" => $p,
            "display" => 10
        ]);

        $data = [];
        if( $mz_list ){
            foreach( $mz_list as $_mz_info ){
                $data[] = [
                    "id" => $_mz_info["id"],
                    "title" => mb_substr( DataHelper::encode( $_mz_info["title"] ),0,10,"utf-8"),
                    "src_url" => $_mz_info['src_url']
                ];
            }
        }
        return $this->render("mz",[
            "mz_list" => $data,
            "page_info" => $page_info,
            "page_url" => "/douban/mz"
        ]);
    }


}