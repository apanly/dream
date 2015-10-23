<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace blog\assets;

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
        'http://cdn.amazeui.org/amazeui/2.4.2/css/amazeui.css',
        'http://cdn.amazeui.org/amazeui/2.4.2/css/amazeui.min.css',
        'css/wap/common.css',
    ];
    public $js = [
        'js/jquery/jquery.min.js',
        'http://cdn.amazeui.org/amazeui/2.4.2/js/amazeui.js',
        'http://cdn.amazeui.org/amazeui/2.4.2/js/amazeui.min.js',
        'http://cdn.amazeui.org/amazeui/2.4.2/js/amazeui.ie8polyfill.js',
        'http://cdn.amazeui.org/amazeui/2.4.2/js/amazeui.ie8polyfill.min.js',
        'http://cdn.amazeui.org/amazeui/2.4.2/js/amazeui.widgets.helper.js',
        'http://cdn.amazeui.org/amazeui/2.4.2/js/amazeui.widgets.helper.min.js',
        'js/wap/common.js'
    ];
}
