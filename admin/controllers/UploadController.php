<?php

namespace admin\controllers;

use admin\controllers\common\BaseController;
use common\components\UploadService;
use common\service\GlobalUrlService;
use common\service\ImagesService;
use Yii;
use common\models\user\User;
use yii\helpers\Url;

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

        $display_url = GlobalUrlService::buildPic1Static($ret['uri'],['w' => 600]);
        return $this->renderJSON([ 'url' => $display_url, 'filename' => $filename ]);
    }

    public function actionFile(){
        $back_url = Url::toRoute("/file/add");

        if ($_FILES["rich_media"]["error"] > 0){
            return $this->renderJS("上传失败!error:". $_FILES["rich_media"]["error"],$back_url);
        }

        if(!is_uploaded_file($_FILES['rich_media']['tmp_name'])){
            return $this->renderJS("非法上传文件",$back_url);
        }

        $type = $_FILES["rich_media"]["type"];
        $filename = $_FILES["rich_media"]["name"];
        $file_size = $_FILES["rich_media"]["size"];

        if( !in_array($type,$this->allow_file_type) ){
            return $this->renderJS("只能上传图片",$back_url);
        }

        if( ( $file_size / 1024 / 1024 ) > 2 ){
            return $this->renderJS("图片不能大约2M",$back_url);
        }



        $ret = UploadService::uploadByFile($filename,$_FILES['rich_media']['tmp_name']);
        if( !$ret ){
            return $this->renderJS(UploadService::getLastErrorMsg(),$back_url);
        }

        return $this->renderJS("上传成功！！",$back_url);

    }

    /**
     * $params = [
     *      "src_path" => '',
     *      "file_key" => '',
     *      "max_width" => ''
     * ]
     */
    public static function resizeImage($params){
        $src_path = $params['src_path'];
        $file_key = $params['file_key'];
        $max_width = $params['max_width'];

        list($width, $height, $type, $attr) = getimagesize($src_path);
        if($width <= $max_width  ) {
            return  $src_path;
        }
        switch ($type) {
            case 1: $img = imagecreatefromgif($src_path); break;
            case 2: $img = imagecreatefromjpeg($src_path); break;
            case 3: $img = imagecreatefrompng($src_path); break;
        }

        if(!$img){
            return  $src_path;
        }

        $scale = $max_width/$width; //求出绽放比例

        $new_width = floor($scale * $width);
        $new_height = floor($scale * $height);
        $newImg = imagecreatetruecolor($new_width, $new_height);

        imagecopyresampled($newImg, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        $desc_path = "/tmp/{$file_key}";

        switch($type) {
            case 1:
                imagegif($newImg, $desc_path);
                break;
            case 2:
                imagejpeg($newImg, $desc_path, 100);
                break;
            case 3:
                imagepng($newImg, $desc_path, 9);
                break;
        }
        imagedestroy($newImg);
        imagedestroy($img);
        return $desc_path;
    }

}