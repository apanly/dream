<?php
namespace common\service;

use blog\components\UrlService;
use common\components\DataHelper;
use common\components\UtilHelper;
use common\models\awephp\AweDocs;
use common\models\awephp\AweMenu;
use common\models\posts\Posts;
use common\models\posts\PostsTags;
use \yii\caching\FileCache;
class CacheHelperService {
	protected static function getCachePath(){
		$root_path = UtilHelper::getRootPath();
		return $root_path.'/common/logs/cache';
	}
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
        $cache->cachePath = self::getCachePath();
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
                ->where(['status' => 1])
				->orderBy([ 'view_count' => SORT_DESC ])
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
				->orderBy([ 'id' => SORT_DESC ])
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
				->orderBy([ 'id' => SORT_DESC ])
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
        $cache->cachePath = self::getCachePath();
        $data = $cache[$cache_key];
        $data = $data?$data:self::buildFront(true);
        $data_attr = json_decode($data,true);
        return $attr_key?$data_attr[$attr_key]:$data_attr;
    }

    public static function buildAweMenu( $refresh = false ){
		$cache = new FileCache();
		$cache_key = "awe_menu";
		$cache->cachePath = self::getCachePath();
		$data = $cache[$cache_key];
		if( !$data || $refresh ){
			$list  = AweMenu::find()->orderBy([ 'weight' => SORT_ASC ])->asArray()->all();
			$data = [];
			if( $list ){
				//先找出一级菜单
				$docs_ids = [];
				foreach( $list as $_item ){
					if(  $_item['parent_id'] == 0  ){
						$data[ $_item['id'] ] = [
							'id' => $_item['id'],
							'title' => DataHelper::encode( $_item['title'] ),
							'sub_menu' => []
						];
					}else{
						$docs_ids[] = $_item['doc_id'];
					}
				}
				//先找出二级菜单
				if( $docs_ids ){
					$docs_mapping = AweDocs::find()->where([ 'id' => $docs_ids,'status' => [ 1,-1 ] ])->indexBy('id')->asArray()->all();
					foreach( $list as $_item ){
						if(  $_item['parent_id'] && isset( $docs_mapping[ $_item['doc_id'] ] )) {
							$tmp_doc_info = $docs_mapping[ $_item['doc_id'] ];
							$data[ $_item['parent_id'] ]['sub_menu'][] = [
								'doc_id' => $tmp_doc_info['id'],
								'doc_title' => DataHelper::encode( $tmp_doc_info['title'] ),
								'status' => $tmp_doc_info['status']
							];
						}
					}
				}
				$data = json_encode($data);
				$cache[ $cache_key ] = $data;
			}
		}
		return $data;
	}

	public static function getAweMenu(){
		$cache = new FileCache();
		$cache_key = "awe_menu";
		$cache->cachePath = self::getCachePath();
		$data = $cache[$cache_key];
		$data = $data?$data:self::buildAweMenu(true);
		return @json_decode($data,true);
	}
} 