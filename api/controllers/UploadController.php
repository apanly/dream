<?php

namespace api\controllers;

use common\components\UploadService;
use common\models\health\HealthLog;
use common\models\posts\RichMedia;
use common\service\health\HealthService;
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
    /*获取健康数据*/
    public function actionHealth(){
        $data = $this->post("data",[]);
        if( !$data ){
            return $this->renderJSON([],"没有数据",-1);
        }
        if( !is_array($data) ){
            return $this->renderJSON([],"数据结构不对",-1);
        }

        $date_step = date("Ymd");
        $lat = $this->post("lat",0);
        $lng = $this->post("lng",0);

        foreach( $data as $_item ){
            $tmp_arr = explode("#",$_item);
            if( count($tmp_arr) != 3 ){
                continue;
            }
            $tmp_params = [
                "quantity" => intval($tmp_arr[0]),
                "time_from" => $tmp_arr[1],
                "time_to" => $tmp_arr[2],
                "lat" => $lat,
                "lng" => $lng
            ];
            HealthService::setLog($tmp_params);
            $date_step = date("Ymd",strtotime($tmp_params['time_from']));
        }
        HealthService::setDay($date_step);
        return $this->renderJSON();
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
        $exif_ifd0_info = isset($exif_info['IFD0'])?$exif_info['IFD0']:[];
        if ($exif_ifd0_info &&
            isset($exif_ifd0_info['Orientation']) && $exif_ifd0_info['Orientation'] == 6) {
            $this->rotate($ret_upload['path']);
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

    /**
     * 翻转处理
     * 覆盖源文件
     */
    private function rotate($file_path){
        list($width, $height, $type, $attr) = getimagesize($file_path);
        switch ($type) {
            case 1: $img = imagecreatefromgif($file_path); break;
            case 2: $img = imagecreatefromjpeg($file_path); break;
            case 3: $img = imagecreatefrompng($file_path); break;
        }

        if(!$img){
            return false;
        }

        $rotate = imagerotate($img, 270, 0);
        switch($type) {
            case 1:
                imagegif($rotate, $file_path);
                break;
            case 2:
                imagejpeg($rotate, $file_path, 100);
                break;
            case 3:
                imagepng($rotate, $file_path, 9);
                break;
        }

        imagedestroy($img);
        imagedestroy($rotate);
    }

}