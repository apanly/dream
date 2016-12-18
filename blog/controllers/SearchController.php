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


class SearchController extends BaseController
{
    public function actionDo(){
        $kw = trim($this->get("kw", ""));
        $p  = intval($this->get("p", 1));
        if (!$p) {
            $p = 1;
        }
        $data = [];
        if (!$kw) {
            return $this->redirect("/");
        }
        $this->setTitle($kw);
        $pagesize = 10;
        $offset   = ($p - 1) * $pagesize;

        $search_key = ['LIKE', 'search_key', '%' . strtr($kw, ['%' => '\%', '_' => '\_', '\\' => '\\\\']) . '%', false];
        $query = IndexSearch::find()->where($search_key);
        $total_count = $query->count();
        $list  = $query->orderBy("id desc")
            ->limit($pagesize)->offset($offset)->all();

        if ($list) {
            $book_mapping = DataHelper::getDicByRelateID($list, Book::className(), "book_id", "id", ["subtitle", "summary", "origin_image_url", "tags"]);

            $post_mapping = DataHelper::getDicByRelateID($list, Posts::className(), "post_id", "id", ["title", "content", "tags"]);

            foreach ($list as $_item) {
                if ($_item['book_id']) {
                    $tmp_target   = $book_mapping[$_item['book_id']];
                    $tmp_content  = mb_substr($tmp_target['summary'], 0, 105, "utf-8");
                    $tmp_title    = DataHelper::encode($tmp_target['subtitle']);
                    $tmp_view_url = Url::toRoute("/library/detail/{$_item['book_id']}");
                } else {
                    $tmp_target   = $post_mapping[$_item['post_id']];
                    $tmp_content  = UtilHelper::blog_summary($tmp_target['content'], 105);
                    $tmp_title    = DataHelper::encode($tmp_target['title']);
                    $tmp_view_url = Url::toRoute("/default/{$_item['post_id']}");
                }

                $tags   = explode(",", $tmp_target['tags']);
                $data[] = [
                    'title'    => $tmp_title,
                    'content'  => nl2br($tmp_content),
                    'tags'     => $tags,
                    'date'     => date("Y年m月d日"),
                    'view_url' => $tmp_view_url
                ];
            }
        }

        $page_info = DataHelper::ipagination([
            "total_count" => $total_count,
            "page_size"    => $pagesize,
            "page"        => $p,
            "display"     => 5
        ]);

        return $this->render("result", [
            "data"      => $data,
            "page_info" => $page_info,
            "urls"      => [
                "page_base" => Url::toRoute(["/search/do", "kw" => $kw])
            ]
        ]);
    }

    public function actionTag(){
        $kw = trim($this->get("kw", ""));
        return $this->redirect( UrlService::buildUrl("/search/do",['kw' => $kw]) );
    }

    public function actionSitemap(){
        $data        = [];
        $tags        = [];


        $type = $this->get("type","blog");
        switch( $type ){
            case "m":
                $domain_host = Yii::$app->params['domains']['m'];
                $sitemap_filename = "m_sitemap.xml";
                break;
            default:
                $domain_host = Yii::$app->params['domains']['blog'];
                $sitemap_filename = "sitemap.xml";
                break;
        }

        $index_urls = [
            'm' => [
                "/default/index?type=1",
                "/default/index?type=2",
                "/default/index?type=3",
                "/library/index",
                "/richmedia/index",
                "/my/about",
                "http://www.vincentguo.cn"
            ],
            'blog' => [
                "/default/index?type=1",
                "/default/index?type=2",
                "/default/index?type=3",
                "/library/index",
                "/richmedia/index",
                "/default/donation",
                "/default/about",
                "http://m.vincentguo.cn"
            ]

        ];

        if( isset( $index_urls[ $type ] ) ){
            foreach ($index_urls[ $type ] as $_index_url) {
                if( preg_match("/^http/",$_index_url) ){
                    $tmp_url = $_index_url;
                }else{
                    if( $type == "m" ){
                        $tmp_url = UrlService::buildWapUrl($_index_url);
                    }else{
                        $tmp_url = UrlService::buildUrl($_index_url);
                    }
                }

                $data[] = [
                    "loc"        => $tmp_url,
                    "priority"   => 1.0,
                    "lastmod"    => date("Y-m-d"),
                    "changefreq" => "daily"
                ];
            }
        }

        $post_list = Posts::find()->where(["status" => 1])->orderBy("id desc")->all();
        if ($post_list) {
            foreach ($post_list as $_post_info) {
                if( $type == "m" ){
                    $tmp_url = UrlService::buildWapUrl("/default/info", ["id" => $_post_info['id']]);
                }else{
                    $tmp_url = UrlService::buildUrl("/default/info", ["id" => $_post_info['id']]);
                }
                $data[]   = [
                    "loc"        => $tmp_url,
                    "priority"   => 1.0,
                    "lastmod"    => date("Y-m-d", strtotime($_post_info['updated_time'])),
                    "changefreq" => "daily"
                ];
                $tmp_tags = explode(",", $_post_info['tags']);
                $tags     = array_merge($tags, $tmp_tags);
            }
        }

        $book_list = Book::find()->where(['status' => 1])->orderBy("id desc")->all();
        if ($book_list) {
            foreach ($book_list as $_book_info) {
                if( $type == "m" ){
                    $tmp_url = UrlService::buildWapUrl("/library/info", ["id" => $_book_info['id']]);
                }else{
                    $tmp_url = UrlService::buildUrl("/library/info", ["id" => $_book_info['id']]);
                }
                $data[] = [
                    "loc"        => $tmp_url,
                    "priority"   => 1.0,
                    "lastmod"    => date("Y-m-d", strtotime($_book_info['updated_time'])),
                    "changefreq" => "daily"
                ];

                $tmp_tags = explode(",", $_book_info['tags']);
                $tags     = array_merge($tags, $tmp_tags);
            }
        }

        $tags = array_unique($tags);
        if ($tags) {
            foreach ($tags as $_tag) {
                if( $type == "m" ){
                    $tmp_url = UrlService::buildWapUrl("/search/do",  ["kw" => $_tag]);
                }else{
                    $tmp_url = UrlService::buildUrl("/search/do",  ["kw" => $_tag]);
                }
                $data[] = [
                    "loc"        => $tmp_url,
                    "priority"   => 1.0,
                    "lastmod"    => date("Y-m-d", time()),
                    "changefreq" => "daily"
                ];
            }
        }

        $xml_content = $this->renderPartial("sitemap", [
            "data" => $data
        ]);

        $app_root  = Yii::$app->getBasePath();
        $file_path = $app_root . "/web/{$sitemap_filename}";
        file_put_contents($file_path, $xml_content);
        $this->layout= false;
        return "ok";
    }
}