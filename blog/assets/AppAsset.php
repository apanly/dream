<?php
namespace blog\assets;

use common\service\GlobalUrlService;
use yii\web\AssetBundle;


class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [];

    public function registerAssetFiles($view){
		$release_version = defined("RELEASE_VERSION") ? RELEASE_VERSION : "20150731141600";
        $this->css = [
            GlobalUrlService::buildStaticUrl("/bootstrap/css/bootstrap.min.css"),
            GlobalUrlService::buildStaticUrl("/bootstrap/css/font-awesome.min.css"),
            "css/screen.min.css?version={$release_version}"
        ];
        $this->js = [
            GlobalUrlService::buildStaticUrl("/jquery/jquery.min.js"),
            GlobalUrlService::buildStaticUrl("/bootstrap/js/bootstrap.min.js"),
            GlobalUrlService::buildStaticUrl("/plugin/layer/layer.js"),
            "js/public.js?version={$release_version}",
            "js/access.js?version={$release_version}",
        ];
        parent::registerAssetFiles($view);
    }
}
