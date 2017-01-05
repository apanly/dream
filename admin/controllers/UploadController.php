<?php

namespace admin\controllers;

use admin\controllers\common\BaseController;
use common\components\UploadService;
use common\components\UtilHelper;
use common\models\Images;
use common\service\GlobalUrlService;
use \admin\components\AdminUrlService;

class UploadController extends BaseController
{

    private $allow_file_type = ["image/jpg","image/gif","image/bmp","image/jpeg","image/png"];//设置允许上传文件的类型

    public function actionPost(){

    	$is_json_flag = false;
		if( $this->get("guid") ){
			$is_json_flag = true;
			$file_target = $_FILES['editormd-image-file'];
		}else{
			$file_target = $_FILES["file"];
		}

        if ($file_target["error"] > 0){
            return $this->renderJSON([],"上传失败!error:". $file_target["error"],-1,$is_json_flag);
        }

        if(!is_uploaded_file($file_target['tmp_name'])){
            return $this->renderJSON([],"非法上传文件!",-1,$is_json_flag);
        }

        $type = $file_target["type"];
        $filename = $file_target["name"];

        if( !in_array($type,$this->allow_file_type) ){
            return $this->renderJSON([],"只能上传图片!",-1,$is_json_flag);
        }

        $ret = UploadService::uploadByFile($filename,$file_target['tmp_name']);
        if( !$ret ){
            return $this->renderJSON([],UploadService::getLastErrorMsg(),-1,$is_json_flag);
        }

        $display_url = GlobalUrlService::buildPic1Static($ret['uri'],['w' => 600]);
        return $this->renderJSON([ 'url' => $display_url, 'filename' => $filename ],'成功',200,$is_json_flag);
    }

    /*文件管理上传文件的*/
    public function actionFile(){
		$call_back_target = 'window.parent.upload';

        if ($_FILES["rich_media"]["error"] > 0){
			return "<script type='text/javascript'>{$call_back_target}.error('"."上传失败!error:". $_FILES["rich_media"]["error"]."');</script>";
        }

        if(!is_uploaded_file($_FILES['rich_media']['tmp_name'])){
			return "<script type='text/javascript'>{$call_back_target}.error('非法上传文件');</script>";
        }

        $type = $_FILES["rich_media"]["type"];
        $filename = $_FILES["rich_media"]["name"];
        $file_size = $_FILES["rich_media"]["size"];

        if( !in_array($type,$this->allow_file_type) ){
			return "<script type='text/javascript'>{$call_back_target}.error('只能上传图片');</script>";
        }

        if( ( $file_size / 1024 / 1024 ) > 2 ){
			return "<script type='text/javascript'>{$call_back_target}.error('图片不能大约2M');</script>";
        }

        $ret = UploadService::uploadByFile($filename,$_FILES['rich_media']['tmp_name']);
        if( !$ret ){
			return "<script type='text/javascript'>{$call_back_target}.error('".UploadService::getLastErrorMsg()."');</script>";
        }

		return "<script type='text/javascript'>{$call_back_target}.success('上传成功');</script>";
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

    /*ueditor编辑器上传*/
    public function actionUeditor(){
        $action = $this->get("action");
        $config_path = UtilHelper::getRootPath()."/admin/web/ueditor/upload_config.json";
        $config = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents($config_path) ), true);
        switch( $action ){
            case 'config':
                echo  json_encode($config);
                break;
            /* 上传图片 */
            case 'uploadimage':
                /* 上传涂鸦 */
            case 'uploadscrawl':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传文件 */
            case 'uploadfile':
                $this->uploadUeditorImage();
                break;
            case 'listimage':
                $this->listUeditorImage();
                break;
        }
    }

    private function uploadUeditorImage(){
        $up_target = $_FILES["upfile"];
        if ($up_target["error"] > 0){
            return $this->retUeditor( "上传失败!error:". $up_target["error"] );
        }

        if(!is_uploaded_file($up_target['tmp_name'])){
            return $this->retUeditor( "非法上传文件!!" );
        }

        $type = $up_target["type"];
        $filename = $up_target["name"];

        if( !in_array($type,$this->allow_file_type) ){
            return $this->retUeditor( "只能上传图片!!" );
        }

        $ret = UploadService::uploadByFile($filename,$up_target['tmp_name']);

        if( !$ret ){
            return $this->retUeditor( UploadService::getLastErrorMsg() );
        }

        if( isset($ret['code']) && $ret['code'] == 205 ){
            return $this->retUeditor( "此图片已经上传过了" );
        }

        $display_url = GlobalUrlService::buildPic1Static($ret['uri'],['w' => 600]);
        //return $this->renderJSON([ 'url' => $display_url, 'filename' => $filename ]);
        return $this->retUeditor("SUCCESS",$display_url,$ret['hash_key'],$filename,$type,$up_target['size']);
    }

    private function listUeditorImage(){
        $start = intval( $this->get("start",0) );
        $page_size = intval( $this->get("size",20) );
        $query = Images::find()->where(['bucket' => "pic1"]);
        if( $start ){
            $query->andWhere(['<',"id",$start]);
        }
        $list = $query->orderBy("id desc")->limit($page_size)->all();
        $images = [];
        $last_id = 0;
        if( $list ){
            foreach( $list as $_item){
                $images[] = [
                    'url' => GlobalUrlService::buildPic1Static($_item['filepath'],['w' => 600]),
                    'mtime' => strtotime( $_item['created_time'] ),
                    'width' => 300
                ];
                $last_id = $_item['id'];
            }
        }

        header('Content-type: application/json');
        $data = [
            "state" => (count($images)> 0 )?'SUCCESS':'no match file',
            "list" => $images,
            "start" => $last_id,
            "total" => count($images)
        ];
        echo  json_encode( $data );
        exit();
    }

    private function retUeditor( $state, $url = '',$title = '',$original = '',$type = '',$size = 0){

        header('Content-type: application/json');
        $data = [
            "state" => $state,
            "url" => $url,
            "title" => $title,
            "original" => $original,
            "type" => $type,
            "size" => $size
        ];
        echo  json_encode( $data );
        exit();
    }

    /*markdown编辑器*/
    public function actionEditorMd(){

		$ret = $this->actionPost();
		$ret = @json_decode( $ret,true );
		$data = [
			'success' => ( $ret['code'] == 200 )?1:0,
			'message' => $ret['msg'],
			'url' => $ret['data']['url']
		];
		echo json_encode( $data );
		\Yii::$app->end();
	}

}