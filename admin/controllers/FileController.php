<?php

namespace admin\controllers;

use admin\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\Images;
use Yii;


class FileController extends BaseController
{
    public function actionIndex(){
        $p = intval( $this->get("p",1) );
        if(!$p){
            $p = 1;
        }

        $data = [];
        $pagesize = 20;
        $query = Images::find();
        $total_count = $query->count();
        $offset = ($p - 1) * $pagesize;
        $image_list = $query->orderBy("id desc")
            ->offset($offset)
            ->limit($pagesize)
            ->all();

        $page_info = DataHelper::ipagination([
            "total_count" => $total_count,
            "pagesize" => $pagesize,
            "page" => $p,
            "display" => 10
        ]);

        if($image_list){
            $idx = 1;
            $domains = Yii::$app->params['domains'];
            foreach($image_list as $_image_info ){
                $data[] = [
                    'idx' =>  $idx,
                    'id' => $_image_info['id'],
                    'url' => $domains[$_image_info['bucket']].$_image_info['filepath']
                ];
                $idx++;
            }
        }
        return $this->render("index",[
            "data" => $data,
            "page_info" => $page_info,
            "page_url" => "/file/index"
        ]);
    }

}