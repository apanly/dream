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
     * 获取客户端IP
     */
    public static function getClientIP(){
        if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        return isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"]:'';
    }
} 