<?php
namespace blog\assets;

use common\service\GlobalUrlService;
use yii\web\AssetBundle;


class BBSV3Asset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [];

    public function registerAssetFiles($view){
		$release_version = defined("RELEASE_VERSION") ? RELEASE_VERSION : "20150731141600";
        $this->css = [
            GlobalUrlService::buildStaticUrl("/bootstrap/css/font-awesome.min.css"),
			"static/v3/css/base.css",
			"static/v3/css/m.css"
        ];
        $this->js = [
            GlobalUrlService::buildStaticUrl("/v3/jquery-1.8.3.min.js"),
			"static/v3/js/comm.js"
        ];
        parent::registerAssetFiles($view);
    }
}
