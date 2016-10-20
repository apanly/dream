<?php
namespace admin\assets;

use yii\web\AssetBundle;


class AdminAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [];

	public function registerAssetFiles($view){
		$this->css = [
			'css/component/scrollbar.min.css',
			'css/common_v2.css'
		];
		$this->js = [
			'js/jquery_v1/jquery-1.12.3.min.js',
			'js/component/jquery.mCustomScrollbar.js',
			'js/component/jquery.mousewheel.min.js',
			"js/jquery_v1/jquery-ui.min.js",
			'js/core.min.js',
			'js/common_v2.js'
		];
		parent::registerAssetFiles($view);
	}
}
