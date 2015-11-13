<?php
namespace common\service;


class GlobalUrlService {
    public static function buildStaticUrl($path){
        $switch = \Yii::$app->params['switch']['cdn']['static'];
        if( $switch ){
            $domain = \Yii::$app->params['domains']['cdn_static'];
        }else{
            $domain = \Yii::$app->params['domains']['static'];
        }

        return $domain.$path;
    }

    public static function buildPic1Static($path,$params = []){
        $switch = \Yii::$app->params['switch']['cdn']['pic1'];
        if( $switch ){
            $domain = \Yii::$app->params['domains']['cdn_pic1'];
        }else{
            $domain = \Yii::$app->params['domains']['pic1'];
        }
        $weight = isset($params['w'])?$params['w']:0;
        $height = isset($params['h'])?$params['h']:0;

        $url = $domain.$path;
        if( !$height && !$weight ){
            return $url;
        }

        if( $switch ){
            if( $height && $weight ){
                $url .= "?imageView2/1/w/{$weight}/h/{$height}/interlace/1";
            }else if( $weight ){
                $url .= "?imageView/2/w/{$weight}";
            }else if( $height ){
                $url .= "?imageView/2/h/{$height}";
            }
        }else{
            if( $height && $weight ){
                $url .= "?format=/w/{$weight}/h/{$height}";
            }else if( $weight ){
                $url .= "?format=/w/{$weight}";
            }else if( $height ){
                $url .= "?format=/h/{$height}";
            }
        }
        return $url;
    }

    public static function buildPicStatic($path,$params = [],$bucket = "pic1"){
        return ($bucket=="pic1")?self::buildPic1Static($path,$params):self::buildPic2Static($path,$params);
    }

    public static function buildPic2Static($path,$params = []){
        $switch = \Yii::$app->params['switch']['cdn']['pic2'];
        if( $switch ){
            $domain = \Yii::$app->params['domains']['cdn_pic2'];
        }else{
            $domain = \Yii::$app->params['domains']['pic2'];
        }
        $weight = isset($params['w'])?$params['w']:0;
        $height = isset($params['h'])?$params['h']:0;

        $url = $domain.$path;
        if( !$height && !$weight ){
            return $url;
        }

        if( $switch ){
            if( $height && $weight ){
                $url .= "?imageView2/1/w/{$weight}/h/{$height}/interlace/1";
            }else if( $weight ){
                $url .= "?imageView/2/w/{$weight}";
            }else if( $height ){
                $url .= "?imageView/2/h/{$height}";
            }
        }else{
            if( $height && $weight ){
                $url .= "?format=/w/{$weight}/h/{$height}";
            }else if( $weight ){
                $url .= "?format=/w/{$weight}";
            }else if( $height ){
                $url .= "?format=/h/{$height}";
            }
        }
        return $url;
    }

    public static function buildUrl($path,$bucket = 'blog',$default_bucket = 'blog'){
        $domains = \Yii::$app->params['domains'];
        if( isset($domains[$bucket]) ){
            $domain = $domains[$bucket];
        }else{
            $domain = $domains[$default_bucket];
        }
        return $domain.$path;
    }
} 