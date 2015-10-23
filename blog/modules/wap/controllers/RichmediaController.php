<?php

namespace blog\modules\wap\controllers;

use blog\modules\wap\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\posts\RichMedia;
use Yii;
use yii\helpers\Url;


class RichmediaController extends BaseController
{
    private $page_size = 10;
    public function actionIndex(){

        $data = [];
        $query = RichMedia::find()->where(['status' => 1,'type' => 'image']);
        $rich_media_list = $query->orderBy("id desc")
            ->limit($this->page_size)
            ->all();

        if($rich_media_list){
            $domains = Yii::$app->params['domains'];
            foreach($rich_media_list as $_rich_info){
                $data[] = [
                    'id' => $_rich_info['id'],
                    'type' => $_rich_info['type'],
                    'src_url' =>  $domains['pic1'].$_rich_info['src_url'],
                    'thumb_url' => $_rich_info['thumb_url']?$_rich_info['thumb_url']:$domains['static']."/wx/video_cover.jpg",
                    'address' => $_rich_info['address']
                ];
            }
        }

        $this->setTitle("富媒体--郭大帅哥的生活记录");
        return $this->render("index",[
            "media_list" => $data
        ]);
    }

}