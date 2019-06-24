<?php
namespace common\components;


class UtilHelper {

    /**
     * 网上找的方法具体的还么有看懂
     */
    public static function blog_summary($body, $size){
        $_size = mb_strlen($body, 'utf-8');
        if($_size <= $size) return $body;

        $strlen_var = strlen($body);
        if(strpos($body, '<') === false){
            return mb_substr($body, 0, $size);
        }
        if($e = strpos($body, '<!-- break -->')){
            return mb_substr($body, 0, $e);
        }
        $html_tag = 0;
        $summary_string = '';
        $html_array_str = '';
        $html_array = array('left' => array(), 'right' => array());
        for($i = 0; $i < $strlen_var; ++$i) {
            if(!$size){
                break;
            }
            $current_var = substr($body, $i, 1);
            if($current_var == '<'){
                $html_tag = 1;
                $html_array_str = '';
            }else if($html_tag == 1){
                if($current_var == '>'){
                    $html_array_str = trim($html_array_str);
                    if(substr($html_array_str, -1) != '/'){
                        $f = substr($html_array_str, 0, 1);
                        if($f == '/'){
                            $html_array['right'][] = str_replace('/', '', $html_array_str);
                        }else if($f != '?'){
                            if(strpos($html_array_str, ' ') !== false){
                                $html_array['left'][] = strtolower(current(explode(' ', $html_array_str, 2)));
                            }else{
                                $html_array['left'][] = strtolower($html_array_str);
                            }
                        }

                    }
                    $html_array_str = '';
                    $html_tag = 0;
                }else{
                    $html_array_str .= $current_var;
                }
            }else{
                --$size;
            }
            $ord_var_c = ord($body{$i});
            switch (true) {
                case (($ord_var_c & 0xE0) == 0xC0):
                    $summary_string .= substr($body, $i, 2);
                    $i += 1;
                    break;
                case (($ord_var_c & 0xF0) == 0xE0):
                    $summary_string .= substr($body, $i, 3);
                    $i += 2;
                    break;
                case (($ord_var_c & 0xF8) == 0xF0):
                    $summary_string .= substr($body, $i, 4);
                    $i += 3;
                    break;
                case (($ord_var_c & 0xFC) == 0xF8):
                    $summary_string .= substr($body, $i, 5);
                    $i += 4;
                    break;
                case (($ord_var_c & 0xFE) == 0xFC):
                    $summary_string .= substr($body, $i, 6);
                    $i += 5;
                    break;
                default:
                    $summary_string .= $current_var;
            }

        }

        if($html_array['left']){
            $html_array['left'] = array_reverse($html_array['left']);
            foreach($html_array['left'] as $index => $tag){
                $key = array_search($tag, $html_array['right']);
                if($key !== false){
                    unset($html_array['right'][$key]);
                }else{
                    $summary_string .= '</'.$tag.'>';
                }
            }

        }
        return $summary_string;
    }

    /**
     * 截取字符串并去除特殊字符
     */

    public static function blog_short($body,$length = 200){
        $content = strip_tags($body);
        $del=array(" ","　","\t","\n","\r","<br>");
        $alt=array("","","","","","");
        $content = str_replace($del,$alt,$content);
        return mb_substr($content,0,$length,"utf-8");
    }

    /**
     * 获取客户端IP
     */
    public static function getClientIP(){
        if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        return isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"]:'';
    }

    /**
     * 判断是pc 还是 手机
     */
    public static function isPC(){
        $ug= isset( $_SERVER['HTTP_USER_AGENT'] )?$_SERVER['HTTP_USER_AGENT']:'';
        $clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-','philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu','android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini','operamobi', 'opera mobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile'
        );
        if(preg_match("/(".implode('|',$clientkeywords).")/i",$ug)
            && strpos($ug,'ipad') === false )
        {
            return false;
        }
        return true;
    }

    /**
     * 判断是否在微信
     */
    public static  function isWechat(){
        $ug= isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'';
        if( stripos($ug,'micromessenger') !== false ){
            return true;
        }
        return false;
    }

    public static function getRootPath(){
        $vendor_path = \Yii::$app->vendorPath;
        return dirname($vendor_path);
    }

    public static function getLibPath($filepath){
        $root_path = self::getRootPath();
        return $root_path."/common/service/libs/".$filepath;
    }

    /**
     * 检测链接是否是SSL连接
     * @return bool
     */
    public static function  is_SSL(){
        if (!isset($_SERVER['HTTPS']))
            return FALSE;
        if ($_SERVER['HTTPS'] === 1){  //Apache
            return TRUE;
        } else if ($_SERVER['HTTPS'] === 'on') { //IIS
            return TRUE;
        } elseif ($_SERVER['SERVER_PORT'] == 443) { //其他
            return TRUE;
        }
        return FALSE;
    }

    /*遮住几位*/
    public static function maskStr( $string,$from=3,$len=0,$mask_char='*' ){
        $mask_str = mb_substr($string,0,$from);
        $strlen = mb_strlen($string,'UTF-8');
        if($from + $len >= $strlen)
        {
            $mask_str .= str_repeat($mask_char,($strlen-$from)>=0 ? ($strlen-$from) : 0);
        }
        else
        {
            $mask_str .= str_repeat($mask_char,$len).mb_substr($string,($from+$len));
        }
        return $mask_str;
    }

    public static function gene_password( $s_options,$length = 16 ) {
        $options = [
            1 => "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
            2 => "!@#$%^&*"
        ];
        $chars = "";
        foreach( $s_options as $_option ){
            $chars .= $options[$_option];
        }

        $password = '';
        for ( $i = 0; $i < $length; $i++ ){
            $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }

        return $password;
    }

    /*
     * UUID是指在一台机器上生成的数字，它保证对在同一时空中的所有机器都是唯一的。通常平台 会提供生成UUID的API。UUID按照开放软件基金会(OSF)制定的标准计算，用到了以太网卡地址、纳秒级时间、芯片ID码和许多可能的数字。由以 下几部分的组合：当前日期和时间(UUID的第一个部分与时间有关，如果你在生成一个UUID之后，过几秒又生成一个UUID，则第一个部分不同，其余相 同)，时钟序列，全局唯一的IEEE机器识别号（如果有网卡，从网卡获得，没有网卡以其他方式获得），UUID的唯一缺陷在于生成的结果串会比较长。关于 UUID这个标准使用最普遍的是微软的GUID(Globals Unique Identifiers)。
在ColdFusion中可以用CreateUUID()函数很简单的生成UUID，其格式为：xxxxxxxx-xxxx-xxxx- xxxxxxxxxxxxxxxx(8-4-4-16)，其中每个 x 是 0-9 或 a-f 范围内的一个十六进制的数字。而标准的UUID格式为：xxxxxxxx-xxxx-xxxx-xxxxxx-xxxxxxxxxx (8-4-4-4-12)
     * */
    public static function gene_guid(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }

        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
        return $uuid;
    }

    public static function getCspHeader( $env = "prod" ){
    	$domains = [
    		'http://v3.jiathis.com',
    		'*.54php.cn',
    		'*.home.54php.cn:4443',
			'*.yunetidc.com',
			'*.baidu.com',
			'*.cnzz.com',
			'*.sohu.com',
			'*.itc.cn',
			'*.jiathis.com',
			'*.qnssl.com',
			"*.wx.qq.com",
			"*.360zhishu.cn",
			"*.qq.com"
		];
    	if( $env != "prod" ){
			$domains[] = '*.dr.test';
			$domains[] = '*.stkf.test';
		}

		$domain_list = implode(" ",$domains);
		return "script-src 'unsafe-inline' 'unsafe-eval' 'self'  {$domain_list};report-uri /error/csp";
	}
} 