<?php
$url = "http://musicmini.baidu.com/app/search/searchList.php?qword=%s&ie=utf-8&page=1";
$url = sprintf($url,urlencode("王菲"));
echo $url;exit();
$data = file_get_contents( $url );
var_export( $data );