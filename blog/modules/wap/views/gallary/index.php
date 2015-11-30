<?php

use blog\components\StaticService;
use \blog\components\UrlService;

StaticService::includeAppCssStatic("/css/mate/gallary/normalize.css", \blog\assets\WapAsset::className());
StaticService::includeAppJsStatic("/js/mate/gallary/main.js",\blog\assets\WapAsset::className());
?>
<style type="text/css">
    html {
        overflow: hidden;
        -ms-touch-action: none;
        -ms-content-zooming: none;
    }
    body {
        position: absolute;
        margin: 0px;
        padding: 0px;
        background: #fff;
        width: 100%;
        height: 100%;
    }
    #screen {
        position: absolute;
        left:0;
        top:0;
        width: 100%;
        height: 100%;
        background:#000;
        perspective:500px;
        -webkit-perspective:500px;
    }

    .cube {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        margin: 0;
        user-select: none;
        transform-style: preserve-3d;
        -webkit-transform-style: preserve-3d;
    }

    .face {
        position: absolute;
        margin-left:-300px;
        margin-top:-200px;
        width:600px;
        height:400px;
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
        transform-origin:50% 50%;
        -webkit-transform-origin:50% 50%;
        transition: outline 0.5s ease-in-out 0s;
        cursor: pointer;
    }

    .button {
        position: absolute;
        margin-left:-150px;
        margin-top:-100px;
        width:300px;
        height:200px;
    }
    .face:hover {
        outline: rgba(255,255,255,1) solid 10px !important;
    }
</style>
<!--[if IE]>
<script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
<![endif]-->
<div id="screen">
    <div id="cube" class='cube'>
        <!-- cube images -->
        <img id="1" src="/gallary/1.jpg" class='face' data-transform="translateZ(-400px)" style="outline:none !important">
        <img id="2" src="/gallary/2.jpg" class='face' data-transform="rotateY(90deg) translateZ(-400px)">
        <img id="3" src="/gallary/3.jpg"  class='face' data-transform="rotateY(-90deg) translateZ(-400px)">
        <img id="4" src="/gallary/4.jpg" class='face' data-transform="rotateY(180deg) translateZ(-400px)">
        <img id="5" src="/gallary/5.jpg" class='face' data-transform="rotateX(90deg) translateZ(-300px)">
        <img id="6" src="/gallary/6.jpg"  class='face' data-transform="rotateX(-90deg) translateZ(-300px)">
        <!-- bonus image -->
        <img id="7" src="/gallary/7.jpg"  class='face' data-transform="rotateY(180deg) translateZ(305px)" style="visibility:hidden">
        <!-- buttons -->
        <img src="/gallary/7.jpg" class='face button' alt="7" data-transform="translateY(-80px) translateZ(-340px) scale(0.5)">
        <img src="/gallary/6.jpg" class='face button' alt="2" data-transform="translateX(-200px) translateY(-80px) translateZ(-340px) scale(0.5)">
        <img src="/gallary/3.jpg"  class='face button' alt="3" data-transform="translateX(200px) translateY(-80px) translateZ(-340px) scale(0.5)">
        <img src="/gallary/4.jpg" class='face button' alt="4" data-transform="translateY(80px) translateZ(-340px) scale(0.5)">
        <img src="/gallary/5.jpg" class='face button' alt="5" data-transform="translateX(-200px) translateY(80px) translateZ(-340px) scale(0.5)">
        <img src="/gallary/6.jpg"  class='face button' alt="6" data-transform="translateX(200px) translateY(80px) translateZ(-340px) scale(0.5)">
    </div>
</div>
