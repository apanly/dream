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
class WapAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [

    ];
    public function registerAssetFiles($view){


//        $this->css = [
//            GlobalUrlService::buildStaticUrl("/amazeui/css/amazeui.css"),
//            GlobalUrlService::buildStaticUrl("/amazeui/css/amazeui.min.css"),
//            'css/wap/common.css',
//        ];
//        $this->js = [
//            'js/jquery/jquery.min.js',
//            GlobalUrlService::buildStaticUrl("/amazeui/js/amazeui.js"),
//            GlobalUrlService::buildStaticUrl("/amazeui/js/amazeui.min.js"),
//            GlobalUrlService::buildStaticUrl("/amazeui/js/amazeui.ie8polyfill.js"),
//            GlobalUrlService::buildStaticUrl("/amazeui/js/amazeui.ie8polyfill.min.js"),
//            GlobalUrlService::buildStaticUrl("/amazeui/js/amazeui.widgets.helper.js"),
//            GlobalUrlService::buildStaticUrl("/amazeui/js/amazeui.widgets.helper.min.js"),
//            'js/wap/common.js'
//        ];
//        parent::registerAssetFiles($view);

        $this->css = [
            'http://cdn.amazeui.org/amazeui/2.4.2/css/amazeui.css',
            'http://cdn.amazeui.org/amazeui/2.4.2/css/amazeui.min.css',
            'css/wap/common.css',
        ];
        $this->js = [
            'js/jquery/jquery.min.js',
            'http://cdn.amazeui.org/amazeui/2.4.2/js/amazeui.js',
            'http://cdn.amazeui.org/amazeui/2.4.2/js/amazeui.min.js',
            'http://cdn.amazeui.org/amazeui/2.4.2/js/amazeui.ie8polyfill.js',
            'http://cdn.amazeui.org/amazeui/2.4.2/js/amazeui.ie8polyfill.min.js',
            'http://cdn.amazeui.org/amazeui/2.4.2/js/amazeui.widgets.helper.js',
            'http://cdn.amazeui.org/amazeui/2.4.2/js/amazeui.widgets.helper.min.js',
            'js/wap/common.js'
        ];
        parent::registerAssetFiles($view);
    }
}
