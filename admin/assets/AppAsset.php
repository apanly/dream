<?php
namespace admin\assets;

use yii\web\AssetBundle;


class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "css/theme-default.css"
    ];
    public $js = [
        "js/jquery/jquery.min.js",
        "js/jquery/jquery-ui.min.js",
        "js/bootstrap/bootstrap.min.js",
//        'js/jquery/plugins/icheck.min.js',
        "js/jquery/plugins/jquery.mCustomScrollbar.min.js",
//        "js/jquery/plugins/scrolltopcontrol.js",
//        "js/jquery/plugins/raphael-min.js",
//        "js/jquery/plugins/morris.min.js",
//        "js/jquery/plugins/d3.v3.js",
//        "js/jquery/plugins/rickshaw.min.js",
//        'js/jquery/plugins/jquery-jvectormap-1.2.2.min.js',
//        'js/jquery/plugins/jquery-jvectormap-world-mill-en.js',
//        'js/bootstrap/bootstrap-datepicker.js',
//        "js/jquery/plugins/owl.carousel.min.js",
//        "js/jquery/plugins/moment.min.js",
//        "js/jquery/plugins/daterangepicker.js",
//        "js/settings.js",
       //"js/posts.js",
 //       "js/actions.js",
//        "js/demo_dashboard.js"
          "js/public/plugins.js",
          "js/public/funs.js",
    ];
}
