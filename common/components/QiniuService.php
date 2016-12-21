<?php

namespace common\components;

use common\service\BaseService;
/*
 * 七牛云存储
 *
 * */
class QiniuService extends  BaseService{

    public static function getUploadKey($key, $bucket = "backup"){

		$upload_info = \Yii::$app->params['upload']['qiniu_config'];
        $auth = new \Qiniu\Auth( $upload_info['ak'], $upload_info['sk'] );

        return $auth->uploadToken($bucket, $key);
    }

    //上传文件
    public static function uploadFile($filePath, $key, $bucket = "backup" ){
        $uploader = new \Qiniu\Storage\UploadManager();
        $token = self::getUploadKey($key, $bucket);
        if ( !file_exists($filePath) ) {
            return self::_err( "文件不存在~~" );
        }
        $ret = $uploader->putFile($token, $key, $filePath);
        if (is_array($ret) && !empty($ret[0]['key'])) {
            return true;
        }
		return self::_err( "上传失败~~" );
    }
}
