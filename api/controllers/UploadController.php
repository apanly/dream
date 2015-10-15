<?php

namespace api\controllers;

use common\components\UploadService;
use common\models\posts\RichMedia;
use Yii;
use api\controllers\common\AuthController;

class UploadController extends AuthController
{
    public function actionMedia(){
        $token = trim( $this->post("token"));
        if( $token != "JRf7gJmxzFm7Uu5X" ){
            return $this->renderJSON([],"非法上传",-1);
        }
        return $this->uploadMedia();
    }

    private function uploadMedia(){
        $allow_file_type = ["image/jpg","image/gif","image/bmp","image/jpeg","image/png","video/mp4"];//设置允许上传文件的类型
        if( !isset($_FILES['richmedia']) ){
            return $this->renderJSON([],'请选择文件！',-1);
        }
        $file_target = $_FILES['richmedia'];
        if($file_target['error'] > 0){
            switch($file_target['error'])
            {
                case 1:
                    return $this->renderJSON([],'文件大小超过服务器限制',-1);
                    break;
                case 2:
                    return $this->renderJSON([],'文件太大!',-1);
                    break;
                case 3:
                    return $this->renderJSON([],'文件只加载了一部分!',-1);
                    break;
                case 4:
                    return $this->renderJSON([],'文件加载失败!',-1);
                    break;
            }
        }

        if(!is_uploaded_file($file_target['tmp_name'])){
            return $this->renderJSON([],"非法上传文件!",-1);
        }

        $type = $file_target["type"];

        if( !in_array($type,$allow_file_type) ){
            return $this->renderJSON([],"只能上传图片!",-1);
        }

        $hash_url = md5( file_get_contents($file_target['tmp_name']) );
        $has_in = RichMedia::findOne(['hash_url' => $hash_url]);
        if( $has_in ){
            return $this->renderJSON([],"上传成功!");
        }


        $ret_upload = UploadService::uploadByFile( $file_target['name'],$file_target['tmp_name'],$hash_url);
        if( !$ret_upload ){
            return $this->renderJSON([],UploadService::getLastErrorMsg(),-1);
        }

        $exif_info = @exif_read_data($ret_upload['path'],0,true);

        if (isset($exif['Orientation']) && $exif['Orientation'] == 6) {
            //旋转imagerotate($img,-90,0);
        }

        $date_now = date("Y-m-d H:i:s");
        $gps = trim( $this->post("gps", ""));
        $tiff = trim( $this->post("tiff", ""));
        $db_type = "image";
        if( $type == "video/mp4" ){
            $db_type = "video";
        }


        $model_rich_media = new RichMedia();
        $model_rich_media->type = $db_type;
        $model_rich_media->src_url = $ret_upload['uri'];
        $model_rich_media->hash_url = $hash_url;
        $model_rich_media->thumb_url = "";
        $model_rich_media->gps = $gps;
        $model_rich_media->tiff = $tiff;
        $model_rich_media->status = 0;
        $model_rich_media->exif = json_encode($exif_info);
        $model_rich_media->updated_time = $date_now;
        $model_rich_media->created_time = $date_now;
        $model_rich_media->save(0);
        return $this->renderJSON([],"上传成功!");

    }

}