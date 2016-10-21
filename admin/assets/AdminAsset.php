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
			'css/common.css'
		];
		$this->js = [
			'js/jquery/jquery-1.12.3.min.js',
			'js/component/jquery.mCustomScrollbar.js',
			'js/component/jquery.mousewheel.min.js',
			'js/core.min.js',
			'js/common.js'
		];
		parent::registerAssetFiles($view);
	}
}
