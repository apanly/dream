<?php
namespace common\components\phpanalysis;



class FenCiService {

    public static function cut($txt){

        $do_fork = $do_unit = true;
        $do_multi = $do_prop = $pri_dict = false;

        PhpAnalysis::$loadInit = false;
        $pa = new PhpAnalysis('utf-8', 'utf-8', $pri_dict);
        //载入词典
        $pa->LoadDict();
        $pa->SetSource($txt);
        $pa->differMax = $do_multi;
        $pa->unitWord = $do_unit;

        $pa->StartAnalysis( $do_fork );
        $okresult = $pa->GetFinallyResult(' ', $do_prop);
        var_dump( $pa->GetFinallyIndex() );
        var_dump($okresult);
    }

    public static function getTags($txt,$len = 10){
        $do_fork = $do_unit = true;
        $do_multi = $do_prop = $pri_dict = true;

        PhpAnalysis::$loadInit = false;
        $pa = new PhpAnalysis('utf-8', 'utf-8', $pri_dict);
        //载入词典
        $pa->LoadDict();
        $pa->SetSource( self::filter_mark($txt) );
        $pa->resultType = 1;
        $pa->notSplitLen = 5;
        $pa->differMax = $do_multi;
        $pa->unitWord = $do_unit;

        $pa->StartAnalysis( $do_fork );
        $ret = $pa->GetFinallyIndex();
        if(!$ret){
            return [];
        }
        $tags = array_keys( array_slice($ret,0,$len,true) );
        return $tags;
    }
    private static function filter_mark($txt){
        $keyword=urlencode( strip_tags($txt) );//将关键字编码
        $keyword=preg_replace("/(%7E|%60|%21|%40|%23|%24|%25|%5E|%26|%27|%2A|%28|%29|%2B|%7C|%5C|%3D|\-|_|%5B|%5D|%7D|%7B|%3B|%22|%3A|%3F|%3E|%3C|%2C|\.|%2F|%A3%BF|%A1%B7|%A1%B6|%A1%A2|%A1%A3|%A3%AC|%7D|%A1%B0|%A3%BA|%A3%BB|%A1%AE|%A1%AF|%A1%B1|%A3%FC|%A3%BD|%A1%AA|%A3%A9|%A3%A8|%A1%AD|%A3%A4|%A1%A4|%A3%A1|%E3%80%82|%EF%BC%81|%EF%BC%8C|%EF%BC%9B|%EF%BC%9F|%EF%BC%9A|%E3%80%81|%E2%80%A6%E2%80%A6|%E2%80%9D|%E2%80%9C|%E2%80%98|%E2%80%99)+/",'',$keyword);
        return urldecode($keyword);//将过滤后的关键字解码
    }
} 