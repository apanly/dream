<?php

namespace blog\controllers;

use blog\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\posts\RichMedia;
use Yii;
use yii\helpers\Url;


class RichmediaController extends BaseController
{
    public function actionIndex(){
        $this->setTitle("富媒体--郭大帅哥的生活记录");
        $p = intval($this->get("p",1));
        if(!$p){
            $p = 1;
        }

        $data = [];
        $pagesize = 20;
        $offset = ($p -1 ) * $pagesize;


        $query = RichMedia::find()->where(['status' => 1]);
        $total_count = $query->count();

        $rich_media_list = $query->orderBy("id desc")
            ->offset($offset)
            ->limit($pagesize)
            ->all();

        if($rich_media_list){
            $domains = Yii::$app->params['domains'];
            foreach($rich_media_list as $_rich_info){
                $data[] = [
                    'id' => $_rich_info['id'],
                    'type' => $_rich_info['type'],
                    'src_url' =>  $domains['pic1'].$_rich_info['src_url'],
                    'thumb_url' => $_rich_info['thumb_url']?$_rich_info['thumb_url']:$domains['static']."/wx/video_cover.jpg",
                ];
            }
        }


        $page_info = DataHelper::ipagination([
            "total_count" => $total_count,
            "pagesize" => $pagesize,
            "page" => $p,
            "display" => 5
        ]);


        return $this->render("index",[
            "data" => $data,
            "page_info" => $page_info,
            'page_url' => Url::toRoute("/richmedia/index")
        ]);
    }

}