<?php

namespace api\modules\emoticon\controllers;

use api\modules\emoticon\controllers\common\BaseController;
use common\models\emoticon\EmoticonLibrary;
use common\service\emoticon\EmoticonService;
use common\service\GlobalUrlService;

class DefaultController extends BaseController
{

	public function actionIndex(){
		header('Access-Control-Allow-Origin:*');
		$p = intval($this->get("p", 1));
		if (!$p || $p < 1) {
			$p = 1;
		}

		$page_size = 15;
		$list      = EmoticonLibrary::find()
			->where(['status' => 1])
			->orderBy(['id' => SORT_DESC])
			->offset(($p - 1) * $page_size)
			->limit($page_size)->all();
		$data      = [];
		if ($list) {
			foreach ($list as $_item) {
				$data[] = [
					'url' => GlobalUrlService::buildPic2Static($_item['url'], ['w' => 100, 'h' => 100]),
					'id'  => $_item['id']
				];
			}
		}
		return $this->renderJSON($data);
	}

	public function actionInfo(){
		header('Access-Control-Allow-Origin:*');
		$id = intval($this->get("id", 0));

		if (!$id) {
			return $this->renderJSON([], '参数错误~~', -1);
		}

		$info = EmoticonLibrary::find()->where(['id' => $id, 'status' => 1])->one();
		if (!$info) {
			return $this->renderJSON([], '参数错误~~', -1);
		}

		$w = intval($this->get("w", 0));
		$w = ceil($w / 50) * 50;
		$w = 200;

		$pre_list = EmoticonLibrary::find()
			->where(['status' => 1])
			->where(['<', 'id', $id])
			->orderBy(['id' => SORT_DESC])
			->limit(5)
			->all();

		$next_list = EmoticonLibrary::find()
			->where(['status' => 1])
			->where(['>', 'id', $id])
			->orderBy(['id' => SORT_ASC])
			->limit(5)
			->all();

		$thunb_images  = [];
		$current_image = [
			'id'        => $info['id'],
			'url'       => GlobalUrlService::buildPic2Static($info['url'], ['w' => $w]),
			'file_name' => $info['url'],
			'small_url' => GlobalUrlService::buildPic2Static($info['url'], ['w' => 100]),
			'share_url' => GlobalUrlService::buildPic2Static($info['url'], ['w' => 200]),
		];

		if ($pre_list) {
			foreach ($pre_list as $_item) {
				$thunb_images[] = [
					'id'        => $_item['id'],
					'url'       => GlobalUrlService::buildPic2Static($_item['url'], ['w' => $w]),
					'file_name' => $_item['url'],
					'small_url' => GlobalUrlService::buildPic2Static($_item['url'], ['w' => 100]),
					'share_url' => GlobalUrlService::buildPic2Static($_item['url'], ['w' => 200])
				];
			}
		}

		$thunb_images[] = $current_image;

		if ($next_list) {
			foreach ($next_list as $_item) {
				$thunb_images[] = [
					'id'        => $_item['id'],
					'url'       => GlobalUrlService::buildPic2Static($_item['url'], ['w' => $w]),
					'file_name' => $_item['url'],
					'small_url' => GlobalUrlService::buildPic2Static($_item['url'], ['w' => 100]),
					'share_url' => GlobalUrlService::buildPic2Static($_item['url'], ['w' => 200])
				];
			}
		}

		$data = [
			'current' => $current_image,
			'gallary' => $thunb_images
		];

		return $this->renderJSON($data);
	}



	public function actionQueue(){
		header('Access-Control-Allow-Origin:*');
		$url = trim($this->post("url", ""));
		if (!$url) {
			return $this->renderJSON([], 'no illage param url ~~', -1);
		}

		$ret = EmoticonService::addQueue(['url' => $url]);
		if (!$ret) {
			return $this->renderJSON([], EmoticonService::getLastErrorMsg(), -1);
		}
		return $this->renderJSON();
	}

	public function actionUpdate(){
		header('Access-Control-Allow-Origin:*');
		$data = [
			'versionCode' => '1.0',
			'versionName' => '0.0.2',
			'msg'         => "1.界面美化
            2.性能优化，更流畅
            3.减少了更新框弹出时间",
			'apk'         => 'http://cdn.static.yunetidc.com/app/dream_blog/dream_blog_v1.0.apk'
		];
		return $this->renderJSON($data);
	}

	public function actionFind(){
		header('Access-Control-Allow-Origin:*');
		$mapping = [
			[
				"icon" => GlobalUrlService::buildStaticUrl("/app/cjdbq/kweather.png"),
				"title" => '天气',
				"url" => 'https://m.baidu.com/s?word=天气预报'
			],
			[
				"icon" => GlobalUrlService::buildStaticUrl("/app/cjdbq/package.png"),
				"title" => '快递查询',
				"url" => 'http://m.kuaidi100.com/uc/index.html'],
			[
				"icon" => GlobalUrlService::buildStaticUrl("/app/cjdbq/happy_face.png"),
				"title" => '爆笑图片',
				"url" => 'http://m.budejie.com/pic/'],
			[
				"icon" => GlobalUrlService::buildStaticUrl("/app/cjdbq/video.png"),
				"title" => '爆笑视频',
				"url" => 'http://m.budejie.com/video/'],
			[
				"icon" => GlobalUrlService::buildStaticUrl("/app/cjdbq/smiling_girl.png"),
				"title" => '最新笑话',
				"url" => 'http://m.budejie.com/text/'
			],
			[
				"icon" => GlobalUrlService::buildStaticUrl("/images/icon.png"),
				"title" => '编程浪子',
				"url" => 'http://m.vincentguo.cn'
			]
		];
		return $this->renderJSON($mapping);
	}
} 