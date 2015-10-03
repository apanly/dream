<?php
//var_dump($_SERVER);exit();
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
//    session_start();//读取session
    $etag = 'W/'.substr( md5($filename),0,8);
    if($_SERVER['HTTP_IF_NONE_MATCH'] == $etag){
        header('HTTP/1.1 304 Not Modified'); //返回304，告诉浏览器调用缓存
        exit();
    }else{
        header('Etag:'.$etag);
    };

    $modified_time = $_SERVER['HTTP_IF_MODIFIED_SINCE'];
    //定义一个合理缓存时间。合理值屈居于页面本身、访问者的数量和页面的更新频率，此处为3600秒(1小时)。
    $time = 30 * 24 * 60 * 60;
    if (strtotime($modified_time) + $time > time()) {
        header("http/1.1 304");
        exit();
    }

    //发送Last-Modified头标，设置文档的最后的更新日期。
    header ("Last-Modified: " .gmdate("D, d M Y H:i:s", time() )." GMT");
    //发送Expires头标，设置当前缓存的文档过期时间，GMT格式。
    header ("Expires: " .gmdate("D, d M Y H:i:s", time()+$time )." GMT");
    //发送Cache_Control头标，设置xx秒以后文档过时,可以代替Expires，如果同时出现，max-age优先。
    header ("Cache-Control: max-age=$time");

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
