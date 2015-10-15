<?php

namespace admin\controllers;

use admin\controllers\common\BaseController;
use common\components\UploadService;
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

        $ret = UploadService::uploadByFile($filename,$_FILES['file']['tmp_name']);
        if( !$ret ){
            return $this->renderJSON([],UploadService::getLastErrorMsg(),-1);
        }

        return $this->renderJSON([ 'url' => $ret['url'], 'filename' => $filename ]);
    }

}