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
        $total_page = ceil($total_count/$pagesize);

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
                    "title" => DataHelper::encode( $_mz_info["title"] ),
                    "src_url" => $_mz_info['src_url']
                ];
            }
        }

        $has_pre = $has_next = false;

        if( ( count( $data ) >= $pagesize ) && ( $p <= $total_page ) ){
            $has_next = true;
        }

        if( $p > 1 ){
            $has_pre = true;
        }

        $this->setTitle("美女也耍流氓 -- 一睹眼福");
        return $this->render("index",[
            "list" => $data,
            "p" => $p,
            "urls" => [
                "has_pre" => $has_pre,
                "has_next" => $has_next
            ]
        ]);
    }
} 