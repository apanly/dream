<?php
//var_dump($_SERVER);exit();
function notFound(){
    header("HTTP/1.1 404 Not Found");
    exit;
}

function setHeader($mod_time,$expired_time = 315360000){
    //发送Last-Modified头标，设置文档的最后的更新日期。
    header ("Last-Modified: " .gmdate("D, d M Y H:i:s", $mod_time )." GMT");
    //发送Expires头标，设置当前缓存的文档过期时间，GMT格式。
    header ("Expires: " .gmdate("D, d M Y H:i:s", $mod_time + $expired_time )." GMT");
    //发送Cache_Control头标，设置xx秒以后文档过时,可以代替Expires，如果同时出现，max-age优先。
    header ("Cache-Control: max-age={$expired_time}");
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
//    $etag = substr( md5($filename),0,8);
//    if($_SERVER['HTTP_IF_NONE_MATCH'] == $etag){
//        header('HTTP/1.1 304 Not Modified'); //返回304，告诉浏览器调用缓存
//        exit();
//    }else{
//        header('Etag:'.$etag);
//    };

    $etag = 'W/'.substr( md5($filename),0,8);
    header('Etag:'.$etag);

    $modified_time = $_SERVER['HTTP_IF_MODIFIED_SINCE'];
    $time = 315360000;//10年缓存时间
    if (strtotime($modified_time) + $time > time()) {
        header('HTTP/1.1 304 Not Modified'); //返回304，告诉浏览器调用缓存
        setHeader( strtotime($modified_time) );//设置缓存
        exit();
    }

    $path = "/data/www/pic1{$filename}";
    if( !file_exists($path) ){
        notFound();
    }

    list($o_w, $o_h, $type) = getimagesize($path);

    if( $w == "5201314" && $h == "5201314" ){
        switch($type){
            case 1:
                header('Content-type: image/gif');
                break;
            case 2:
                header('Content-type: image/jpg');
                break;
            case 3:
                header('Content-type: image/png');
                break;
        }
        echo file_get_contents( $path );
        exit();
    }


    if( $h <= 0 ){
        $w = ( $o_w > $w)?$w:$o_w;
        $h = ceil( $o_h * $w / $o_w );
    }

    if( $w <= 0 ){
        $h = ( $o_h > $h)?$h:$o_h;
        $w = ceil( $o_w * $h / $o_h );
    }

    switch($type){
        case 1:
            $src=imagecreatefromgif($path);
            break;
        case 2:
            $src=imagecreatefromjpeg($path);
            break;
        case 3:
            $src=imagecreatefrompng($path);
            break;
    }

    if( !$src ){
        notFound();
    }

    setHeader( time() );//设置缓存

    $image=imagecreatetruecolor($w, $h);
    imagecopyresampled($image, $src, 0, 0, 0, 0, $w, $h, $o_w, $o_h);


    switch($type) {
        case 1:
            header('Content-type: image/gif');
            imagegif($image);
            break;
        case 2:
            header('Content-type: image/jpg');
            imagejpeg($image, null, 100);
            break;
        case 3:
            header('Content-type: image/png');
            imagepng($image, null, 9);
            break;
    }
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

if( isset( $_SERVER['HTTP_USER_AGENT'] ) &&  stripos($_SERVER['HTTP_USER_AGENT'],"qiniu-imgstg-spider") !== false  ){
    $format = "w/5201314/h/5201314";
}

if( !$filename || !$format ){
    echo "params filename  and  format must be assigned";exit();
}
$ret = getFormat( $format );
resizeimage($filename,$ret['w'],$ret['h']);
