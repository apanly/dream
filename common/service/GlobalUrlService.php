<?php
namespace common\service;

use common\components\UtilHelper;
use yii\helpers\Url;

class GlobalUrlService {
    public static function buildStaticUrl($path,$params = []){
        $switch = \Yii::$app->params['switch']['cdn']['static'];
        if( $switch ){
            if( UtilHelper::is_SSL() ){
                $domain = \Yii::$app->params['domains']['cdn_static_https'];
            }else{
                $domain = \Yii::$app->params['domains']['cdn_static'];
            }

        }else{
            $domain = \Yii::$app->params['domains']['static'];
            if( stripos($domain,"http") === false ){
                $domain = "http:".$domain;
            }
        }
        $path = Url::toRoute(array_merge([$path],$params));
        return $domain.$path;
    }

	public static function buildStaticPic($path,$params = []){
		$switch = \Yii::$app->params['switch']['cdn']['static'];
		if( $switch ){
			if( UtilHelper::is_SSL() ){
				$domain = \Yii::$app->params['domains']['cdn_static_https'];
			}else{
				$domain = \Yii::$app->params['domains']['cdn_static'];
			}
		}else{
			$domain = \Yii::$app->params['domains']['static'];
			if( stripos($domain,"http") === false ){
				$domain = "http:".$domain;
			}
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
		}
		return $url;
	}

    public static function buildPic1Static($path,$params = [],$need_watermark = false){
        $switch = \Yii::$app->params['switch']['cdn']['pic1'];
        if( $switch ){
            if( UtilHelper::is_SSL() ){
                $domain = \Yii::$app->params['domains']['cdn_pic1_https'];
            }else{
                $domain = \Yii::$app->params['domains']['cdn_pic1'];
            }

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
            //七牛设置的水印
			if( $need_watermark ){
				$url .= "|watermark/2/text/57yW56iL5rWq5a2Q55qE5Y2a5a6iIHd3dy52aW5jZW50Z3VvLmNu/font/5a6L5L2T/fontsize/500/fill/IzBENDJFNw==/dissolve/100/gravity/SouthEast/dx/10/dy/10";
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
        return self::buildPicStaticUrl($bucket,$path,$params);
    }


    public static function buildPicStaticUrl($bucket,$path,$params = []){
        if( !$bucket || !$path ){
            return false;
        }

        $switch = \Yii::$app->params['switch']['cdn'][$bucket];
        if( $switch ){
            if( UtilHelper::is_SSL() ){
                $domain = \Yii::$app->params['domains']['cdn_'.$bucket.'_https'];
            }else{
                $domain = \Yii::$app->params['domains']['cdn_'.$bucket];
            }

        }else{
            $domain = \Yii::$app->params['domains'][$bucket];
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

    public static function buildPic2Static($path,$params = []){
        $switch = \Yii::$app->params['switch']['cdn']['pic2'];
        if( $switch ){
            if( UtilHelper::is_SSL() ){
                $domain = \Yii::$app->params['domains']['cdn_pic2_https'];
            }else{
                $domain = \Yii::$app->params['domains']['cdn_pic2'];
            }
        }else{
            $domain = \Yii::$app->params['domains']['pic2'];
        }
        $weight = isset($params['w'])?$params['w']:0;
        $height = isset($params['h'])?$params['h']:0;

        if( substr($path,0,1) != "/" ){
            $path = "/".$path;
        }

        $url = $domain.$path;
        if( !$height && !$weight ){
            return $url;
        }

        if( $switch ){
            if( $height && $weight ){
                $url .= "?imageView2/2/w/{$weight}/h/{$height}/interlace/1";
            }else if( $weight ){
                $url .= "?imageView2/2/w/{$weight}";
            }else if( $height ){
                $url .= "?imageView2/2/h/{$height}";
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


    public static function buildBlogUrl($uri, $params = []){
        $path = Url::toRoute(array_merge([$uri], $params));
        $domain_blog = \Yii::$app->params['domains']['blog'];
        if( UtilHelper::is_SSL() ){
            $domain_blog = str_replace("http://","https://",$domain_blog);
        }
        return $domain_blog.$path;
    }


    public static function buildWapUrl($uri, $params = []){
        if(substr($uri,0,1) != "/") {
            $uri = "/" . $uri;
        }
        $path = Url::toRoute(array_merge([$uri], $params));
        $domain_m = \Yii::$app->params['domains']['m'];
        if( UtilHelper::is_SSL() ){
            $domain_m = str_replace("http://","https://",$domain_m);
        }
        return $domain_m.$path;
    }


    public static function buildGameUrl($uri, $params = []){
        $path = Url::toRoute(array_merge(["/game" . $uri], $params));
        $domain_blog = \Yii::$app->params['domains']['blog'];
        if( UtilHelper::is_SSL() ){
            $domain_blog = str_replace("http://","https://",$domain_blog);
        }
        return $domain_blog.$path;
    }

    public static function buildMateUrl($uri, $params = []){
        $path = Url::toRoute(array_merge(["/mate" . $uri], $params));
        $domain_blog = \Yii::$app->params['domains']['blog'];
        if( UtilHelper::is_SSL() ){
            $domain_blog = str_replace("http://","https://",$domain_blog);
        }
        return $domain_blog.$path;
    }

    public static function buildNullUrl(){
    	return "javascript:void(0);";
	}
} 