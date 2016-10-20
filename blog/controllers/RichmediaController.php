<?php

namespace blog\controllers;

use blog\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\posts\RichMedia;
use common\service\GlobalUrlService;
use Yii;
use yii\helpers\Url;


class RichmediaController extends BaseController
{
    public function actionIndex(){
        $this->setTitle("富媒体");
        $p = intval($this->get("p", 1));
        if (!$p) {
            $p = 1;
        }

        $data     = [];
        $pagesize = 20;
        $offset   = ($p - 1) * $pagesize;


        $query       = RichMedia::find()->where(['status' => 1]);
        $total_count = $query->count();

        $rich_media_list = $query->orderBy("id desc")
            ->offset($offset)
            ->limit($pagesize)
            ->all();

        if ($rich_media_list) {
            $domains = Yii::$app->params['domains'];
            foreach ($rich_media_list as $_rich_info) {
                $tmp_small_pic_url = GlobalUrlService::buildPic1Static($_rich_info['src_url'],['h' => 400]);
                $tmp_big_pic_url = GlobalUrlService::buildPic1Static($_rich_info['src_url'],['w' => 600]);
                $data[] = [
                    'id'        => $_rich_info['id'],
                    'type'      => $_rich_info['type'],
                    'small_src_url'   => $tmp_small_pic_url,
                    'big_src_url'   => $tmp_big_pic_url,
                    'thumb_url' => $_rich_info['thumb_url'] ? $_rich_info['thumb_url'] : $domains['static'] . "/wx/video_cover.jpg",
                    'address'   => $_rich_info['address']
                ];
            }
        }


        $page_info = DataHelper::ipagination([
            "total_count" => $total_count,
            "page_size"    => $pagesize,
            "page"        => $p,
            "display"     => 5
        ]);


        return $this->render("index", [
            "data"      => $data,
            "page_info" => $page_info,
            'page_url'  => Url::toRoute("/richmedia/index")
        ]);
    }

}