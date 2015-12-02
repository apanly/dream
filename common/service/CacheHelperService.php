<?php
namespace common\service;

use blog\components\UrlService;
use common\components\DataHelper;
use common\components\UtilHelper;
use common\models\posts\Posts;
use common\models\posts\PostsTags;
use \yii\caching\FileCache;
class CacheHelperService {

    /*
     * 前端要用到的东西
     * tag limit (20)
     * origin post (limit 10)
     * hot post (limit 10)
     * latest post (limit 10 )
    */
    public static function buildFront($refresh = false){
        $cache = new FileCache();
        $cache_key = "tag_post";
        $root_path = UtilHelper::getRootPath();
        $cache->cachePath = $root_path.'/common/logs/cache';
        $data = $cache[$cache_key];

        if( !$data || $refresh ){
            $data = [
                "tag" => [],
                "post_hot" => [],
                "post_origin" => [],
                "post_latest" => []
            ];

            $tags = PostsTags::find()
                ->select("tag,count(*) as num ")
                ->groupBy("tag")
                ->orderBy("num desc")
                ->limit(20)
                ->all();
            if( $tags ){
                foreach( $tags as $_tag ){
                    $data['tag'][] = $_tag['tag'];
                }
            }


            $post_hot = Posts::find()
                ->where(['status' => 1,'hot' => 1])
                ->limit(10)
                ->all();
            if( $post_hot ){
                foreach( $post_hot as $_post_info ){
                    $data['post_hot'][] = [
                        "id" => $_post_info['id'],
                        "title" => DataHelper::encode( $_post_info["title"] ),
                        "detail_url" => UrlService::buildUrl("/default/info",["id" => $_post_info['id'] ])
                    ];
                }
            }

            $post_origin = Posts::find()
                ->where(['status' => 1,'original' => 1])
                ->limit(10)
                ->all();
            if( $post_origin ){
                foreach( $post_origin as $_post_info ){
                    $data['post_origin'][] = [
                        "id" => $_post_info['id'],
                        "title" => DataHelper::encode( $_post_info["title"] ),
                        "detail_url" => UrlService::buildUrl("/default/info",["id" => $_post_info['id'] ])
                    ];
                }
            }

            $post_latest = Posts::find()
                ->where(['status' => 1])
                ->orderBy("id desc")
                ->limit(10)
                ->all();
            if( $post_latest ){
                foreach( $post_latest as $_post_info ){
                    $data['post_latest'][] = [
                        "id" => $_post_info['id'],
                        "title" => DataHelper::encode( $_post_info["title"] ),
                        "detail_url" => UrlService::buildUrl("/default/info",["id" => $_post_info['id'] ])
                    ];
                }
            }

            $data = json_encode($data);
            $cache[ $cache_key ] = $data;
        }
        return $data;
    }

    public static function getFrontCache($attr_key = ''){
        $cache = new FileCache();
        $cache_key = "tag_post";
        $root_path = UtilHelper::getRootPath();
        $cache->cachePath = $root_path.'/common/logs/cache';
        $data = $cache[$cache_key];
        $data = $data?$data:self::buildFront(true);
        $data_attr = json_decode($data,true);
        return $attr_key?$data_attr[$attr_key]:$data_attr;
    }
} 