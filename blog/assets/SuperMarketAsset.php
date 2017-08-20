<?php

namespace blog\assets;

use common\service\GlobalUrlService;
use yii\web\AssetBundle;


class SuperMarketAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [

    ];
    public function registerAssetFiles($view){
        $this->css = [
			GlobalUrlService::buildStaticUrl("/bootstrap/css/metro-bootstrap.min.css"),
			GlobalUrlService::buildStaticUrl("/fontawesome/css/font-awesome.min.css"),
			"css/market/index.css",
		];
        $this->js = [
            GlobalUrlService::buildStaticUrl("/jquery/jquery.min.js"),
			'js/market/common.js'
        ];

        parent::registerAssetFiles($view);
    }
}
