<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace blog\assets;

use common\service\GlobalUrlService;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MateAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [

    ];
    public function registerAssetFiles($view){
        $this->css = [
            GlobalUrlService::buildStaticUrl("/amazeui/css/amazeui.min.css"),
            'css/mate/common.css',
        ];
        $this->js = [
            GlobalUrlService::buildStaticUrl("/jquery/jquery.min.js"),
            GlobalUrlService::buildStaticUrl("/amazeui/js/amazeui.min.js"),
            GlobalUrlService::buildStaticUrl("/amazeui/js/amazeui.ie8polyfill.min.js"),
            GlobalUrlService::buildStaticUrl("/amazeui/js/amazeui.widgets.helper.min.js"),
            'js/mate/common.js',
            "js/access.js",
        ];
        parent::registerAssetFiles($view);
    }
}
