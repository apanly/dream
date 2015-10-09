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

        $date_now = date("Y-m-d H:i:s");


        $upload_dir_pic1 = Yii::$app->params['upload']['pic1'];
        $folder_name = date("Ymd",strtotime($date_now));
        $upload_dir = $upload_dir_pic1.$folder_name;
        if( !file_exists($upload_dir) ){
            mkdir($upload_dir);
        }

        $tmp_file_extend = explode(".", $filename);
        $hash_key = md5( file_get_contents($_FILES['file']['tmp_name']) );
        $upload_file_name = "{$folder_name}/{$hash_key}.".end($tmp_file_extend);

        if(!move_uploaded_file($_FILES['file']['tmp_name'],$upload_dir_pic1.$upload_file_name) ){
            return $this->renderJSON([],"上传失败！！系统繁忙请稍后再试!",-1);
        }
        $domains = Yii::$app->params['domains'];
        $url = $domains['pic1']."/{$upload_file_name}";

        ImagesService::add($hash_key,$filename,"/".$upload_file_name,"");

        return $this->renderJSON([
                'url' => $url,
                'filename' => $filename
            ]
        );
    }

}