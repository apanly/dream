<?php

namespace blog\modules\game\controllers;

use blog\modules\game\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\games\Doubanmz;

class MvController extends BaseController
{
    public function actionIndex(){
        $p = intval( $this->get("p",1) );
        if(!$p){
            $p = 1;
        }


        $pagesize = 10;
        $query = Doubanmz::find();
        $total_count = $query->count();
        $offset = ($p - 1) * $pagesize;
        $mz_list = $query->orderBy("id desc")
            ->offset($offset)
            ->limit($pagesize)
            ->all();

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

        return $this->render("index",[
            "list" => $data
        ]);
    }
} 