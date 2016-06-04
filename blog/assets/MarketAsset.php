<?php

namespace blog\assets;

use common\service\GlobalUrlService;
use yii\web\AssetBundle;


class MarketAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [

    ];
    public function registerAssetFiles($view){
        $this->css = [];
        $this->js = [
            GlobalUrlService::buildStaticUrl("/jquery/jquery.min.js")
        ];
        parent::registerAssetFiles($view);
    }
}
