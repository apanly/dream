<?php
namespace common\service;

use apanly\metaweblog\MetaWeblog;
use common\models\metaweblog\BlogSyncMapping;
use common\models\metaweblog\BlogSyncQueue;
use common\models\posts\Posts;
/**
 * 同步博客到各大平台
 */
class SyncBlogService extends BaseService {

    public static $type_mapping = [
        "51cto" => "cto51_id",
        "csdn" => "csdn_id",
        "sina" => "sina_id",
        "163" => "netease_id",
        "oschina" => "oschina_id",
        "cnblogs" => "cnblogs_id",
        "chinaunix" => "chinaunix_id"
    ];

    public static function doSync( $type,$blog_id ){
        $charset = "utf-8";
        $catlog = [ 1 ];
        $limit_title_len = 0;//不限制
        switch( $type ){
            case "51cto":
                $catlog = [
                    "【创作类型:原创】",
                    "开发技术"
                ];
                $charset = "gb2312";
                break;
            case "csdn":
                $catlog = [];
                //return self::_err("目前还处理不了这个类型!!");
                break;
            case "sina":
                break;
            case "163":
                break;
            case "oschina":
                break;
            case "cnblogs":
                break;
            case "chinaunix":
                $catlog = [
                    "Web开发"
                ];
				$limit_title_len = 30;
                break;
            default:
                return self::_err("指定的类型无法处理!!");
                break;
        }

        $metaweblog_blog_config = \Yii::$app->params['metaweblog'];
        if( !isset( $metaweblog_blog_config[ $type] ) ){
            return self::_err("指定的类型无法处理!!");
        }

        $metaweblog_config = $metaweblog_blog_config[ $type];

        $blog_info = Posts::findOne(['id' => $blog_id,"status" => 1]);
        if( !$blog_info ){
            return self::_err("博客不存在哦!!");
        }
        $domain_blog = \Yii::$app->params['domains']['blog'];
        $link = $domain_blog."/default/{$blog_id}.html?source={$type}";
        $content = $blog_info['content'];
        $title = $blog_info['title'];

		if( $limit_title_len ){//标题限制长度
			$title = mb_substr( $title,0 ,$limit_title_len,"utf-8" );
		}

        $content .= "<br/>原文地址：<a href=\"{$link}\">{$blog_info['title']}</a>";
        /*相关标签*/
        if( $blog_info['tags'] ){
            $content .="<br/>标签：";
            $tmp_tags = explode(",",$blog_info['tags'] );
            foreach( $tmp_tags as $_tmp_tag ){
                $tmp_link = $domain_blog."/search/do?kw={$_tmp_tag}&source_id={$blog_id}&source={$type}";
                $content .= "<a href='{$tmp_link}'>{$_tmp_tag}</a> &nbsp;&nbsp;";
            }
        }
        /*加入推荐*/
        $recommend_blogs = RecommendService::getRecommendBlog( $blog_id );
        if( $recommend_blogs ){
            $content .="<br/><br/><h3>智能推荐</h3><ul>";
            foreach( $recommend_blogs as $_recommend_blog ){
                $tmp_link = $domain_blog."/default/{$_recommend_blog['id']}.html?flag=recommend&source={$type}&source_id=".$_recommend_blog['source_id'];
                $content .="<li><a href='{$tmp_link}'>{$_recommend_blog["title"]}</a></li>";
            }
            $content .="</ul>";
        }


        $content = htmlspecialchars( $content );
        $title = htmlspecialchars( $title );
        if( $charset != "utf-8" ){
            $content = mb_convert_encoding($content,$charset,"utf-8");
            $title = mb_convert_encoding($title,$charset,"utf-8");
        }

        $params = [
            'title'=> $title,
            'description'=> $content ,
            'categories'=> $catlog
        ];

        $target =  new MetaWeblog( $metaweblog_config['url'], $charset );
        $target->setAuth( $metaweblog_config['username'], $metaweblog_config['passwd'] );

        $date_now = date("Y-m-d H:i:s");

        $sync_info = BlogSyncMapping::findOne( ['blog_id' => $blog_id] );

        $is_edit = false;

        if( $sync_info && $sync_info[ self::$type_mapping[ $type] ] ){
            if( !$target->editPost(  $sync_info[ self::$type_mapping[ $type] ], $params ) ){
                return self::_err( $target->getErrorCode()."：".$target->getErrorMessage()." xml data:".$target->getResponse() );
            }
            $model_blog_sync_mapping = $sync_info;
            $is_edit = true;
        }else{
            if( !$target->newPost(  $params,($type == "csdn" ) ) ){
                return self::_err( $target->getErrorCode()."：".$target->getErrorMessage()." xml data:".$target->getResponse() );
            }
            if( $sync_info ){
                $model_blog_sync_mapping = $sync_info;
            }else{
                $model_blog_sync_mapping = new BlogSyncMapping();
                $model_blog_sync_mapping->blog_id = $blog_id;
                $model_blog_sync_mapping->created_time = $date_now;
            }
        }

        $sync_blog_id = $target->getBlogId();
        if( !$is_edit ){
            $model_blog_sync_mapping[ self::$type_mapping[ $type ] ] = $sync_blog_id;
        }
        $model_blog_sync_mapping->updated_time = $date_now;

        if( !$model_blog_sync_mapping->save(0) ){
            return false;
        }
        return $target->getResponse();
    }


    public static function addQueue($blog_id){
        $date_now = date("Y-m-d H:i:s");
        foreach( self::$type_mapping as $_type => $_f ){
            $has_not_handle_task = BlogSyncQueue::findOne([ 'blog_id' => $blog_id,'status' => -1,'type' => $_type ]);
            if( $has_not_handle_task ){
                continue;
            }

            $tmp_model_blog_sync_queue = new BlogSyncQueue();
            $tmp_model_blog_sync_queue->blog_id = $blog_id;
            $tmp_model_blog_sync_queue->type = $_type;
            $tmp_model_blog_sync_queue->status = -1;
            $tmp_model_blog_sync_queue->updated_time = $date_now;
            $tmp_model_blog_sync_queue->created_time= $date_now;
            $tmp_model_blog_sync_queue->save(0);

        }

    }


} 