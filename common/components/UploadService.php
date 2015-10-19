<?php
/**
 * 此类进行文件到pic1 和 pic2中
 * 图片不允许自定义key,其他可以
 * 统一上传
 */

namespace common\components;


use common\service\BaseService;
use common\service\ImagesService;
use Yii;

class UploadService extends  BaseService{

    protected static $allow_file_type = ["jpg","gif","bmp","jpeg","png"];//设置允许上传文件的类型

    public static function uploadByFile($filename,$filepath,$hash_key = "",$bucket = "pic1"){
        if( !$filename ){
            return self::_err("参数文件名是必要参数");
        }
        if( !$filepath || !file_exists($filepath) ){
            return self::_err("请传入合法的参数filepath");
        }

        $date_now = date("Y-m-d H:i:s");
        $tmp_file_extend = explode(".", $filename);
        $file_type = end($tmp_file_extend);
        if( !in_array( $file_type ,self::$allow_file_type)  && !$hash_key){
            return self::_err("非图片格式必须指定参数hask_key");
        }

        if( in_array( $file_type ,self::$allow_file_type) ){
            $hash_key = md5( file_get_contents($filepath) );
        }

        $upload_dir_pic = \Yii::$app->params['upload'][$bucket];

        $has_uploaded = ImagesService::checkHashKey($hash_key);
        if( $has_uploaded ){
            $domain_bucket = \Yii::$app->params['domains'][$has_uploaded['bucket']];
            return [
                'url' => $domain_bucket."/".$has_uploaded['filepath'],
                'path' => $upload_dir_pic.substr($has_uploaded['filepath'],1),
                'uri' => $has_uploaded['filepath']
            ];
        }


        $folder_name = date("Ymd",strtotime($date_now));
        $upload_dir = $upload_dir_pic.$folder_name;
        if( !file_exists($upload_dir) ){
            mkdir($upload_dir,0777);
            chmod($upload_dir,0777);
        }

        $upload_file_name = "{$folder_name}/{$hash_key}.".$file_type;

        if( is_uploaded_file($filepath) ){
            if(!move_uploaded_file($filepath,$upload_dir_pic.$upload_file_name) ){
                return self::_err("上传失败！！系统繁忙请稍后再试!");
            }
        }else{
            file_put_contents($upload_dir_pic.$upload_file_name,file_get_contents($filepath) );
        }

        ImagesService::add($bucket,$hash_key,$filename,"/".$upload_file_name,"");

        $domain_bucket = \Yii::$app->params['domains'][$bucket];

        return [
            'url' => $domain_bucket."/".$upload_file_name,
            'path' => $upload_dir_pic.$upload_file_name,
            'uri' => "/{$upload_file_name}"
        ];
    }

    public static function uploadByUrl($url,$hash_key = "",$bucket = "pic1"){
        if( !$url ){
            return self::_err("参数url必须被指定");
        }

        $data = file_get_contents($url);
        if( !$data ){
            return self::_err("提供的url没有抓取到内容");
        }

        $date_now = date("Y-m-d H:i:s");
        $tmp_file_extend = explode(".", $url);
        $file_type = end($tmp_file_extend);
        $filename = substr(md5( $url ),9,8);

        if( !in_array( $file_type ,self::$allow_file_type)  && !$hash_key){
            return self::_err("非图片格式必须指定参数hask_key");
        }

        if( in_array( $file_type ,self::$allow_file_type) ){
            $hash_key = md5( $data );
        }

        $upload_dir_pic = \Yii::$app->params['upload'][$bucket];

        $has_uploaded = ImagesService::checkHashKey($hash_key);
        if( $has_uploaded ){
            $domain_bucket = \Yii::$app->params['domains'][$has_uploaded['bucket']];
            return [
                'url' => $domain_bucket."/".$has_uploaded['filepath'],
                'path' => $upload_dir_pic.substr($has_uploaded['filepath'],1),
                'uri' => $has_uploaded['filepath']
            ];
        }


        $folder_name = date("Ymd",strtotime($date_now));
        $upload_dir = $upload_dir_pic.$folder_name;
        if( !file_exists($upload_dir) ){
            mkdir($upload_dir,0777);
            chmod($upload_dir,0777);
        }

        $upload_file_name = "{$folder_name}/{$hash_key}.".$file_type;
        file_put_contents($upload_dir_pic.$upload_file_name,$data);

        ImagesService::add($bucket,$hash_key,$filename,"/".$upload_file_name,$url);

        $domain_bucket = \Yii::$app->params['domains'][$bucket];

        return [
            'url' => $domain_bucket."/".$upload_file_name,
            'path' => $upload_dir_pic.$upload_file_name,
            'uri' => "/{$upload_file_name}"
        ];

    }
} 