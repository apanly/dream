<?php
namespace common\service\emoticon;
use common\components\HttpClient;
use common\models\emoticon\EmoticonLibrary;
use common\models\emoticon\EmoticonQueue;
use common\service\BaseService;
use common\service\QiniuUploadService;

class EmoticonService extends  BaseService{

	public static function addQueue( $params ){
		if( !$params || !isset( $params['url'] ) ){
			return self::_err('url must be ~~');
		}

		$uniq_key = md5( $params['url'] );
		$has_in = EmoticonQueue::find()->where([ 'uniq_key' => $uniq_key ])->count();
		if( $has_in  ){
			return true;
		}

		$model_face = new EmoticonQueue();
		$model_face->source = isset( $params['source'] )?$params['source']:0;
		$model_face->type = isset( $params['type'] )?$params['type']:0;
		$model_face->url = $params['url'];
		$model_face->uniq_key =$uniq_key;
		$model_face->status = -1;
		$model_face->updated_time = date("Y-m-d H:i:s");
		$model_face->created_time = $model_face->updated_time;
		return $model_face->save(0);
	}


	public static function scrapy( $data = [] ){

		if( !$data || !isset( $data['url'] ) || !isset($data['type']) ){
			return self::_err('param not enough ~~');
		}

		if(  $data['type']  != 1 ){
			return self::_err('just handle type => 1(pic) ~~');
		}

		$url = $data['url'];
		/*以下host网站都放在cdn了，非常快不用放到我的cdn中去了*/
		$cdn_host = [
			'read.html5.qq.com1'
		];
		$ignore_host = [
			'photo.jokeji.cn',
			'gaoxiao.jokeji.cn',
			'upfile.asqql.com',
			'pk.156music.com'
		];

		$host = parse_url( $url ,PHP_URL_HOST );
		if( !$host ){
			return self::_err('no host');
		}

		if( in_array($host,$ignore_host)  ){
			return self::_err('host be ignore~~');
		}

		$params = [
			'title' => $data['title'],
			'url' => $url,
		];

		if( !in_array($host,$cdn_host) ){//下载图片并上传到七牛CDN
			$upload_target  = new QiniuUploadService();
			$ret = $upload_target->saveFile( $url );
			if( !$ret ){
				return self::_err('upload file');
			}

			if( !isset( $ret[0] ) || !isset( $ret[0]['key'] ) ){
				return self::_err('upload reps no key');
			}

			$params['cdn_source'] = 1;
			$params['self_cdn'] = 1;
			$params['url'] = $ret[0]['key'];
		}

		return self::save2Library( $params );

	}


	public static function parseImages( $data ){
		if( !$data || !isset( $data['url'] ) || !isset($data['type']) ){
			return self::_err('param not enough ~~');
		}

		if(  $data['type']  != 2 ){
			return self::_err('just handle type => 2( website need to parse to get images) ~~');
		}

		$url = $data['url'];
		$host = parse_url( $url ,PHP_URL_HOST );
		if( !$host ){
			return self::_err('no host');
		}

		$content = HttpClient::get( $url );

		switch ($host){
			case "www.18weixin.com":
				$content = mb_convert_encoding($content, 'gb2312', 'utf-8');
				$html_dom = new \HtmlParser\ParserDom($content);
				$tmp_images_wrap = $html_dom->find('div.picadd',0);
				foreach( $tmp_images_wrap->find("img") as $tmp_image_target ){

					$tmp_target_url = $tmp_image_target->getAttr("src");
					if( !$tmp_target_url ){
						continue;
					}

					if( substr($tmp_target_url,0,4) != "http" ){
						$tmp_target_url = "http://".$host.$tmp_target_url;
					}


					self::addQueue([ 'url' => $tmp_target_url,'type' => 1 ]);
				}
				break;
		}

		return true;

	}

	public static function save2Library( $params ){
		if( !$params || !isset( $params['url'] ) ){
			return self::_err('url must be ~~');
		}

		$model_library = new EmoticonLibrary();
		$model_library->title = isset( $params['title'] )?$params['title']:'';
		$model_library->url = $params['url'];
		$model_library->cdn_source = isset( $params['cdn_source'] )?$params['cdn_source']:0;
		$model_library->self_cdn = isset( $params['self_cdn'] )?$params['self_cdn']:0;
		$model_library->cdn_rule = isset( $params['cdn_rule'] )?$params['cdn_rule']:'';
		$model_library->group_name = isset( $params['group_name'] )?$params['cdn_rule']:'';
		$model_library->status = 0 ;
		$model_library->updated_time = date("Y-m-d H:i:s");
		$model_library->created_time = $model_library->updated_time;
		return $model_library->save(0);
	}
}