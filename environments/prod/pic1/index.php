<?php

function notFound(){
    header("HTTP/1.1 404 Not Found");
    exit;
}

/**
 * resizeimage
 * 缩放图片，节省资源
 */
function resizeimage($filename,$w,$h = 0,$format = "jpg"){

    if( $w <=0 && $h <= 0){
        notFound();
    }
    $path = "/data/www/pic1{$filename}";

    list($o_w, $o_h) = getimagesize($path);

    if( $h <= 0 ){
        $w = ( $o_w > $w)?$w:$o_w;
        $h = ceil( $o_h * $w / $o_w );
    }

    if( $w <= 0 ){
        $h = ( $o_h > $h)?$h:$o_h;
        $w = ceil( $o_w * $h / $o_h );
    }

    $src=imagecreatefromjpeg($path);
    $image=imagecreatetruecolor($w, $h);
    imagecopyresampled($image, $src, 0, 0, 0, 0, $w, $h, $o_w, $o_h);
    header('content-type:image/jpg');
    imagejpeg($image,null,100);
    imagedestroy($image);
    exit();
}

function getFormat($format){
    $ret = [
        'w' => 0,
        'h' => 0
    ];

    if( substr($format,0,1) == "/" ){
        $format = substr($format,1);
    }
    $info = explode("/",$format);
    $w_key = array_search("w",$info);
    if( $w_key !== false ){
        $ret['w'] = $info[$w_key + 1];
    }

    $h_key = array_search("h",$info);
    if( $h_key !== false ){
        $ret['h'] = $info[$h_key + 1];
    }

    return $ret;
}

$filename = $_GET['filename'];
$format = $_GET['format'];
$ret = getFormat( $format );
resizeimage($filename,$ret['w'],$ret['h']);
