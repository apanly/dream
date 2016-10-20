<?php

namespace admin\controllers;

use admin\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\Images;
use common\service\GlobalUrlService;
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
            "page_size" => $pagesize,
            "page" => $p,
            "display" => 10
        ]);

        if($image_list){
            $idx = 1;

            foreach($image_list as $_image_info ){
                $tmp_small_pic_url = GlobalUrlService::buildPicStatic($_image_info['filepath'],['h' => 100,'w' => 200],$_image_info['bucket']);
                $tmp_big_pic_url = GlobalUrlService::buildPicStatic($_image_info['filepath'],['w' => 600],$_image_info['bucket']);

                $data[] = [
                    'idx' =>  $idx,
                    'id' => $_image_info['id'],
                    'small_pic_url' => $tmp_small_pic_url,
                    'big_pic_url' => $tmp_big_pic_url,
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

    public function actionAdd(){
        $request = Yii::$app->request;
        if( $request->isGet ){
            return $this->render("add");
        }
    }
}