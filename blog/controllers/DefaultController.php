<?php

namespace blog\controllers;

use blog\components\BlogUtilService;
use blog\components\UrlService;
use blog\controllers\common\BaseController;
use common\components\barcode\BarCodeService;
use common\components\DataHelper;
use common\components\UtilHelper;
use common\models\posts\Posts;
use common\models\posts\PostsRecommend;
use common\models\soft\Soft;
use common\service\CacheHelperService;
use common\service\Constant;
use common\service\GlobalUrlService;
use common\service\RecommendService;
use console\modules\blog\Blog;
use dosamigos\qrcode\lib\Enum;
use dosamigos\qrcode\QrCode;
use Yii;


class DefaultController extends BaseController{

    public function actionIndex(){
        $type = intval($this->get("type", 1));
        $type = in_array($type, [1, 2, 3,4]) ? $type : 1;

        $p = intval($this->get("p", 1));
        if (!$p) {
            $p = 1;
        }

        $data     = [];
        $pagesize = 10;
        $offset   = ($p - 1) * $pagesize;


        $query = Posts::find()->where(['status' => 1]);
		switch ( $type ){
			case 2:
				$query->andWhere([ 'soul' => 0 ]);
				$query->orderBy( [ 'view_count' => SORT_DESC ] );
				break;
			case 3:
				$query->andWhere([ 'original' => 1,'soul' => 0]);
				$query->orderBy( [ 'id' => SORT_DESC ] );
				break;
			case 4:
				$query->andWhere([ 'soul' => 1 ]);
				$query->orderBy( [ 'id' => SORT_DESC ] );
				break;
			default:
				$query->andWhere([ 'soul' => 0 ]);
				$query->orderBy( [ 'id' => SORT_DESC ] );
				break;
		}

        $total_count = $query->count();

        $posts_info = $query->offset($offset)->limit($pagesize)->all();

        $soft_page_size = 5;
		$soft_list = Soft::find()->where([ 'status' => 1 ])
			->orderBy([ 'id' => SORT_DESC ])
			->offset(  ( $p - 1 ) * $soft_page_size )
			->limit( $soft_page_size )->all();

		$author = Yii::$app->params['author'];
		$soft_data = [];

		if( $soft_list ){
			foreach (  $soft_list as $_item  ){
				$soft_data[]      = [
					'id' => $_item['id'],
					'title'  => DataHelper::encode($_item['title']),
					'author' => $author,
					'image_url' => $_item['image_url'],
					'view_count' => $_item['view_count'],
					'type_desc' => Constant::$soft_type[ $_item['type'] ],
					'date'  => date("Y.m.d", strtotime($_item['updated_time'])),
					'view_url' =>  GlobalUrlService::buildSuperMarketUrl( "/default/info" ,[ "id" => $_item['id'] ] ),
					'from' => "soft"
				];
			}
		}

        if ($posts_info) {
            $idx    = 1;
            foreach ($posts_info as $_post) {
                $tmp_content = UtilHelper::blog_summary($_post['content'], 105);
                $tags = explode(",", $_post['tags']);
                $data[]      = [
                    'idx' => $idx,
                    'id' => $_post['id'],
                    'sn' => $_post['sn'],
                    'title'  => DataHelper::encode($_post['title']),
                    'content' => nl2br($tmp_content),
                    'original' => $_post['original'],
                    'view_count' => $_post['view_count'],
                    'author' => $author,
                    'tags'  => $tags,
                    'date'  => date("Y.m.d", strtotime($_post['updated_time'])),
                    'view_url' => UrlService::buildUrl( "/default/info" ,[ "id" => $_post['id'] ] ),
					'from' => "blog"
                ];

                if( isset( $soft_data[ $idx - 1 ] ) ){
					$data[] = $soft_data[ $idx - 1 ];
				}
				$idx++;
            }
        }



        $page_info = DataHelper::ipagination([
            "total_count" => $total_count,
            "page_size"    => $pagesize,
            "page"        => $p,
            "display"     => 5
        ]);


        $tags = CacheHelperService::getFrontCache("tag");

        return $this->render("index", [
            "data"      => $data,
            "page_info" => $page_info,
            "type"      => $type,
            "hot_kws"   => array_slice($tags,0,5)
        ]);

    }

    public function actionInfo( $id ){

        if (!$id) {
            return $this->goHome();
        }
        $post_info = Posts::findOne(['id' => $id, 'status' => 1]);

        if (!$post_info) {
            return $this->goHome();
        }


        $author = Yii::$app->params['author'];
        $tags  = explode(",", $post_info['tags']);
        $content = preg_replace("/brush:(\w+);toolbar:false/","prettyprint linenums",$post_info['content']);
        $content = str_replace("<pre>","<pre class='prettyprint linenums'>",$content);

        $data = [
            "id"  => $post_info['id'],
            "title" => $post_info['title'],
            "content"  => $content,
            "original" => $post_info['original'],
			'view_count' => $post_info['view_count'],
            "tags" => $tags,
            'date' => date("Y.m.d", strtotime($post_info['updated_time'])),
            'author' => $author,
            "url"  => UrlService::buildUrl("/default/info", [ "id" => $post_info['id'] ])
        ];

        $prev_info = Posts::find()
            ->where(["<", "id", $post_info['id'] ])
            ->andWhere(['status' => 1])
            ->orderBy("id desc")
            ->one();

        $next_info = Posts::find()
            ->where([">", "id", $post_info['id'] ])
            ->andWhere(['status' => 1])
            ->orderBy("id asc")
            ->one();

        $this->setTitle($post_info['title']);

        return $this->render("detail", [
            "info"      => $data,
            "prev_info" => $prev_info,
            "next_info" => $next_info,
            "recommend_blogs" => RecommendService::getRecommendBlog( $post_info['id'] )
        ]);
    }

    public function actionAbout(){
        $this->setTitle("简介");
        return $this->render("about");
    }

    public function actionDonation(){
        $this->setTitle("感谢每一位支持的好朋友~~");
        return $this->render("donation");
    }

    public function actionChangeLog(){
        $this->setTitle("更新日志");
        return $this->render("changelog",[
            'list' => BlogUtilService::getChangeLog()
        ]);
    }

    public function actionApp(){
		$this->setTitle("App下载页面");
		return $this->render("app",[
			'list' => BlogUtilService::getChangeLog()
		]);
	}

    public function actionQrcode(){
        $qr_text = $this->get("qr_text",GlobalUrlService::buildBlogUrl("/"));
        header('Content-type: image/png');
        QrCode::png($qr_text,false,Enum::QR_ECLEVEL_H,5,0,false);
        exit();
    }

    private $barcode_mapping = [
        'ean13' => 'BCGean13',
        'isbn' => 'BCGisbn'
    ];

    public function actionBarcode(){
        $barcode = $this->get("barcode","");
        $type = $this->get("type","BCGcode39");
        $barcode_class = "BCGcode39";
        if( isset( $this->barcode_mapping[$type] ) ){
            $barcode_class =$this->barcode_mapping[$type];
        }

        BarCodeService::create(  $barcode,$barcode_class  );
    }

}