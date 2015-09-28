<?php

namespace admin\controllers;

use admin\controllers\common\BaseController;
use common\service\ImagesService;
use Yii;
use common\models\user\User;

class UploadController extends BaseController
{

    private $allow_file_type = ["image/jpg","image/gif","image/bmp","image/jpeg","image/png"];//设置允许上传文件的类型


    public function actionPost(){
        if ($_FILES["file"]["error"] > 0){
            return $this->renderJSON([],"上传失败!error:". $_FILES["file"]["error"],-1);
        }

        if(!is_uploaded_file($_FILES['file']['tmp_name'])){
            return $this->renderJSON([],"非法上传文件!",-1);
        }

        $type = $_FILES["file"]["type"];
        $filename = $_FILES["file"]["name"];

        if( !in_array($type,$this->allow_file_type) ){
            return $this->renderJSON([],"只能上传图片!",-1);
        }

        $upload_base_dir = realpath(__DIR__."/../../static/web/uploads/");
        $upload_dir = $upload_base_dir."/".date("Ymd")."/";

        if( !file_exists($upload_dir) ){
            mkdir($upload_dir);
        }

        $tmp_file_extend = explode(".", $filename);

        $upload_file_path = $upload_dir.date("YmdHis")."_".substr(md5($filename),0,8).".".end($tmp_file_extend);
        $hash_key = md5( file_get_contents($_FILES['file']['tmp_name']) );
        if(!move_uploaded_file($_FILES['file']['tmp_name'],$upload_file_path) ){
            return $this->renderJSON([],"上传失败！！系统繁忙请稍后再试!",-1);
        }
        $domains = Yii::$app->params['domains'];
        $url = str_replace($upload_base_dir,$domains['static']."/uploads",$upload_file_path);
        $filepath = str_replace($upload_base_dir,"",$upload_file_path);

        ImagesService::add($hash_key,$filename,$filepath,$url);

        return $this->renderJSON([
                'url' => $url,
                'filename' => $filename
            ]
        );
    }

    public function actionTest(){

    }


}