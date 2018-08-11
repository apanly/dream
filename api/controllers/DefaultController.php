<?php

namespace api\controllers;

use common\components\DataHelper;
use common\components\UtilHelper;

use common\models\library\Book;
use common\models\posts\Posts;
use common\models\posts\RichMedia;
use common\service\GlobalUrlService;
use common\service\RecommendService;
use Yii;
use api\controllers\common\AuthController;

class DefaultController extends AuthController{
    public function actionIndex(){
        return "Hi Guest,IP:".UtilHelper::getClientIP().",Time:".date('Y-m-d H:i:s');
    }

    public function actionBanner(){
        $list = Posts::find()
            ->where([ 'original' => 1 ])
            ->orderBy([ "id" => SORT_DESC ])
            ->limit(5)
            ->all();

        $ret = [];
        if( $list ){
            foreach( $list as $_info ){
                $tmp_image_url = GlobalUrlService::buildStaticUrl("/images/web/blog_default.jpg");
                if( $_info['image_url'] ){
                    $tmp_image_url = $_info['image_url'];
                }
                $tmp_pos_idx = stripos($tmp_image_url,"?");
                if( $tmp_pos_idx !== false ){
                    $tmp_image_url = substr($tmp_image_url,0,$tmp_pos_idx);
                }
                $ret[] = [
                    'title' => $_info['title'],
                    'id' => $_info['id'],
                    'type' => 'blog',
                    'image_url' => $tmp_image_url
                ];
            }
        }
        return $this->renderJSON([ 'list' => $ret ]);
    }

    private $page_size = 10;
    public function actionBlog(){
        $p = $this->get("p",1);
        $offset = ($p - 1) * $this->page_size;

        $query = Posts::find()->where(['status' => 1]);
        $posts_info = $query->orderBy("id desc")
            ->offset($offset)
            ->limit($this->page_size)
            ->all();
        $data  = [];

        if ($posts_info) {
            foreach ($posts_info as $_post) {
                $tmp_image_url = GlobalUrlService::buildStaticUrl("/images/web/blog_default_list.jpg");
                if( $_post['image_url'] ){
                    $tmp_image_url = $_post['image_url'];
                }
                $tmp_pos_idx = stripos($tmp_image_url,"?");
                if( $tmp_pos_idx !== false ){
                    $tmp_image_url = substr($tmp_image_url,0,$tmp_pos_idx);
                }
                $tmp_tags = explode(",", $_post['tags']);
                $data[] = [
                    'title' => $_post['title'],
                    'content' => UtilHelper::blog_short( str_replace("&nbsp;"," ", $_post['content'] ), 100),
                    "tags" => $tmp_tags,
                    'image_url' => $tmp_image_url,
                    'id' => $_post['id'],
                    'created_time' => date("Y-m-d H:i",strtotime( $_post['created_time'] ) )
                ];
            }
        }
		$has_more = ( count( $data ) < $this->page_size )?0:1;
        return $this->renderJSON([ 'list' => $data,'has_more' => $has_more ]);
    }

    public function actionInfo(){
        $id = intval( $this->post("id",0) );
        if( !$id ){
            return $this->renderJSON([],"指定博文不存在",-1);
        }

        $post_info = Posts::find()->where([ 'status' => 1,'id' => $id ])->one();
        if( !$post_info ){
            return $this->renderJSON([],"指定博文不存在",-1);
        }

        $tmp_tags = explode(",", $post_info['tags']);

        $content = preg_replace("/brush:(\w+);toolbar:false/","prettyprint linenums",$post_info['content']);


        $info = [
            'author' => DataHelper::getAuthorName(),
            'title' => $post_info['title'],
            'content' => $content,
            "tags" => $tmp_tags,
            'updated_time' => date("Y-m-d H:i",strtotime( $post_info['updated_time'] ) ),
        ];

        $share_info = [
            'title' => $post_info['title'],
            'content' => UtilHelper::blog_short($post_info['content'],200),
            'url' => GlobalUrlService::buildWapUrl("/default/info",[ 'id' => $post_info['id'] ])
        ];

        return $this->renderJSON([
        	'info' => $info,
			'share_info' => $share_info,
			"recommend_blogs" => RecommendService::getRecommendBlog( $id )
		]);
    }

    public function actionMedia(){
        $p = intval($this->get("p", 1));
        $offset = ($p - 1) * $this->page_size;

        $query = RichMedia::find()->where(['status' => 1,'type' =>'image' ]);
        $rich_media_list = $query->orderBy("id desc")
            ->offset($offset)
            ->limit($this->page_size)
            ->all();

        $data = [];
        if ($rich_media_list) {
            foreach ($rich_media_list as $_rich_info) {
                $data[] = [
                    'image_url' => GlobalUrlService::buildPic1Static($_rich_info['src_url']),
                    'title'  => $_rich_info['address']?$_rich_info['address']:':('
                ];
            }
        }
        return $this->renderJSON([ 'list' => $data ]);
    }

    public function actionBook(){
        $p = intval($this->get("p", 1));
        $offset = ($p - 1) * $this->page_size;

        $query = Book::find()->where(['status' => 1 ]);
        $books = $query->orderBy("id desc")
            ->offset($offset)
            ->limit($this->page_size)
            ->all();

        $data = [];
        if ($books) {
            foreach ($books as $_book) {
                $data[] = [
                    'id' => $_book['id'],
                    'image_url' => GlobalUrlService::buildPic1Static($_book['image_url']),
                    'title'  => $_book['subtitle']
                ];
            }
        }
        return $this->renderJSON([ 'list' => $data ]);
    }

    public function actionUpdate(){
        return $this->renderJSON([ 'status' => 1 ]);
    }
}