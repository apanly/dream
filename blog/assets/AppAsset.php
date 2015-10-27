<?php
namespace blog\assets;

use yii\web\AssetBundle;


class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "css/bootstrap/bootstrap.min.css",
        "css/bootstrap/font-awesome.min.css",
        "css/bootstrap/monokai_sublime.min.css",
        "css/screen.css",
        "css/common.css"
    ];
    public $js = [
        "js/jquery/jquery.min.js",
        "js/bootstrap/bootstrap.min.js",
        "js/jquery/jquery.fitvids.min.js",
        "js/bootstrap/highlight.min.js",
        "js/main.js",
        "js/public.js",
    ];
}
