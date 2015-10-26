<?php

namespace blog\controllers;

use blog\components\UrlService;
use blog\controllers\common\BaseController;
use common\components\DataHelper;
use common\components\UtilHelper;
use common\models\library\Book;
use common\models\posts\Posts;
use common\models\search\IndexSearch;
use Yii;
use yii\helpers\Url;


class SearchController extends BaseController{
    public function actionDo(){
        $kw = trim( $this->get("kw",""));
        $p = intval($this->get("p",1));
        if(!$p){
            $p = 1;
        }
        $data = [];
        if( !$kw ){
            return $this->redirect("/");
        }
        $this->setTitle($kw." - 郭大帅哥的博客");
        $pagesize = 10;
        $offset = ($p -1 ) * $pagesize;

        $search_key =  ['LIKE' ,'search_key','%'.strtr($kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false];
        $query = IndexSearch::find()->where($search_key);
        $total_count = $query->count();
        $list = $query->orderBy("id desc")
            ->limit($pagesize)
            ->offset($offset)
            ->all();


        if( $list ){
            $book_mapping = DataHelper::getDicByRelateID($list,Book::className(),"book_id","id",["subtitle","summary","origin_image_url","tags"]);

            $post_mapping = DataHelper::getDicByRelateID($list,Posts::className(),"post_id","id",["title","content","tags"]);

            foreach($list as $_item){
                if($_item['book_id']){
                    $tmp_target = $book_mapping[$_item['book_id']];
                    $tmp_content = mb_substr($tmp_target['summary'],0,105,"utf-8");
                    $tmp_title = DataHelper::encode($tmp_target['subtitle']);
                    $tmp_view_url = Url::toRoute("/library/detail/{$_item['book_id']}");
                }else{
                    $tmp_target = $post_mapping[$_item['post_id']];
                    $tmp_content = UtilHelper::blog_summary($tmp_target['content'],105);
                    $tmp_title = DataHelper::encode($tmp_target['title']);
                    $tmp_view_url = Url::toRoute("/default/{$_item['post_id']}");
                }

                $tags = explode(",",$tmp_target['tags']);
                $data[] = [
                    'title' => $tmp_title,
                    'content' => nl2br( $tmp_content ),
                    'tags' => $tags,
                    'date' => date("Y年m月d日"),
                    'view_url' => $tmp_view_url
                ];
            }
        }

        $page_info = DataHelper::ipagination([
            "total_count" => $total_count,
            "pagesize" => $pagesize,
            "page" => $p,
            "display" => 5
        ]);

        return $this->render("result",[
            "data" => $data,
            "page_info" => $page_info,
            "urls" => [
                "page_base" => Url::toRoute(["/search/do","kw" => $kw])
            ]
        ]);
    }

    public function actionSitemap(){
        $post_list = Posts::find()->where(["status" => 1])->orderBy("id desc")->all();
        $data = [];

        if( $post_list ){
            $domain_blog = Yii::$app->params['domains']['blog'];
            foreach( $post_list as $_post_info ){
                $data[] = [
                    "loc" => $domain_blog.UrlService::buildUrl("/default/info",["id" => $_post_info['id'] ] ),
                    "priority" => 1.0,
                    "lastmod" => date("Y-m-d",strtotime( $_post_info['updated_time'] ) ),
                    "changefreq" => "daily"
                ];
            }
        }

        $xml_content = $this->renderPartial("sitemap",[
            "data" => $data
        ]);

        $app_root = Yii::$app->getBasePath();
        $file_path = $app_root."/web/sitemap.xml";
        file_put_contents($file_path,$xml_content);

    }
}