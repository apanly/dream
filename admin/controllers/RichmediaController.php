<?php

namespace admin\controllers;

use admin\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\posts\RichMedia;
use common\service\GlobalUrlService;
use Yii;
use yii\helpers\Url;


class RichmediaController extends BaseController
{
    private $status_desc = [
        0 => ['class' => 'danger','desc' => "隐藏"],
        1 => ['class' => 'success','desc' => "正常"]
    ];
    public function actionIndex(){
        $p = intval( $this->get("p",1) );
        if(!$p){
            $p = 1;
        }

        $data = [];
        $pagesize = 20;

        $query = RichMedia::find()->where(['status' => [0,1] ]);
        $total_count = $query->count();
        $offset = ($p - 1) * $pagesize;
        $rich_list = $query->orderBy("id desc")
            ->offset($offset)
            ->limit($pagesize)
            ->all();

        $page_info = DataHelper::ipagination([
            "total_count" => $total_count,
            "pagesize" => $pagesize,
            "page" => $p,
            "display" => 10
        ]);

        if($rich_list){
            $idx = 1;
            $domains = Yii::$app->params['domains'];
            foreach($rich_list as $_rich_info){
                $tmp_small_pic_url = GlobalUrlService::buildPic1Static($_rich_info['src_url'],['h' => 100]);
                $tmp_big_pic_url = GlobalUrlService::buildPic1Static($_rich_info['src_url'],['w' => 600]);

                $data[] = [
                    'idx' =>  $idx,
                    'id' => $_rich_info['id'],
                    'small_src_url' => $tmp_small_pic_url,
                    'big_src_url' => $tmp_big_pic_url,
                    'src_url' => $tmp_small_pic_url,
                    'thumb_url' => $_rich_info['thumb_url']?$_rich_info['thumb_url']:$domains['static']."/wx/video_cover.jpg",
                    'type' => $_rich_info['type'],
                    'address' => $_rich_info['address'],
                    'status' => $_rich_info['status'],
                    'status_info' => $this->status_desc[$_rich_info['status']],
                    'created' => $_rich_info['created_time'],
                ];
                $idx++;
            }
        }

        return $this->render("index",[
            "data" => $data,
            "page_info" => $page_info,
            "page_url" => "/richmedia/index"
        ]);
    }

    public function actionOps($id){
        $id = intval($id);
        $act = trim($this->post("act","online"));
        if( !$id ){
            return $this->renderJSON([],"操作的多媒体可能不是你的吧!!",-1);
        }
        $richmedia_info = RichMedia::findOne(["id" => $id]);

        if( !$richmedia_info ){
            return $this->renderJSON([],"操作的多媒体可能不是你的吧!!",-1);
        }

        if($act == "del" ){
            $richmedia_info->status = 0;
        }else if($act == "online"){
            $richmedia_info->status = 1;
        }else{//goaway
            $richmedia_info->status = -1;
        }

        $richmedia_info->updated_time = date("Y-m-d H:i:s");
        $richmedia_info->update(0);
        return $this->renderJSON([],"操作成功!!");
    }

    public function actionEdit($id){
        $id = intval($id);
        $address = trim( $this->post("address","") );
        if( !$id ){
            return $this->renderJSON([],"操作的多媒体可能不是你的吧!!",-1);
        }

        if( mb_strlen($address,"utf-8") < 1 ){
            return $this->renderJSON([],"地址不能为空!!",-1);
        }

        $richmedia_info = RichMedia::findOne(["id" => $id]);

        if( !$richmedia_info ){
            return $this->renderJSON([],"操作的多媒体可能不是你的吧!!",-1);
        }
        $richmedia_info->address = $address;
        $richmedia_info->update(0);
        return $this->renderJSON([],"操作成功！！");
    }

}