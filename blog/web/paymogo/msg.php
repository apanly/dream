<?php

if(array_key_exists('echostr',$_GET) && $_GET['echostr']){//用于微信第一次认证的
	echo $_GET['echostr'];exit();
}

$xml_data = file_get_contents("php://input");

file_put_contents("weixin.log", "[xml_data]:". $xml_data );