<?php
namespace common\service;


use common\components\HttpClient;

class QiniuUploadService extends BaseService
{
	public function getConfig()
	{
		return \Yii::$app->params['upload']['qiniu_config'];
	}

	public function getUploadKey($key, $bucket = "vincentguo-pic2")
	{

		$config = $this->getConfig();
		$auth   = new \Qiniu\Auth($config['ak'], $config['sk']);

		if (!empty($config['bucket'])) {
			$bucket = $config['bucket'];
		}
		return $auth->uploadToken($bucket, $key);
	}


	public function saveFile($file_url,$bucket = "vincentguo-pic2")
	{

		if (!$file_url) {
			return self::_err('param file_url must be ~~');
		}
		// 执行输出
		$content   = HttpClient::get( $file_url );

		if (!$content) {
			return self::_err('file_url no content ~~');
		}
		$key = md5( $content );
		$uploader = new \Qiniu\Storage\UploadManager();
		$token = $this->getUploadKey($key, $bucket);
		$ret = $uploader->put($token, $key, $content);
		return $ret;
	}

}