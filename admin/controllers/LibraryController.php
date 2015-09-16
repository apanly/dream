<?php

namespace admin\controllers;

use admin\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\library\Book;
use common\models\posts\Posts;
use common\models\posts\PostsTags;
use common\service\Constant;
use Yii;
use yii\helpers\Url;


class LibraryController extends BaseController
{
    private $status_desc = [
        0 => ['class' => 'danger','desc' => "隐藏"],
        1 => ['class' => 'success','desc' => "正常"]
    ];
    public function actionIndex(){
        $p = intval( $this->get("p",1) );
        if(!$p){
            $p = 1;
        }

        $data = [];
        $pagesize = 20;

        $query = Book::find();
        $total_count = $query->count();
        $offset = ($p - 1) * $pagesize;
        $book_info = $query->orderBy("id desc")
            ->offset($offset)
            ->limit($pagesize)
            ->all();

        $page_info = DataHelper::ipagination([
            "total_count" => $total_count,
            "pagesize" => $pagesize,
            "page" => $p,
            "display" => 10
        ]);

        if($book_info){
            $idx = 1;
            $domains = Yii::$app->params['domains'];
            foreach($book_info as $_book){
                $tmp_title = $_book['subtitle'];

                $data[] = [
                    'idx' =>  $idx,
                    'id' => $_book['id'],
                    'title' => DataHelper::encode($tmp_title),
                    'status' => $_book['status'],
                    'status_info' => $this->status_desc[$_book['status']],
                    'created' => $_book['created_time'],
                    'edit_url' => Url::toRoute("/library/detail/{$_book['id']}"),
                    'view_url' => $domains['blog'].Url::toRoute("/library/detail/{$_book['id']}")
                ];
                $idx++;
            }
        }

        return $this->render("index",[
            "data" => $data,
            "page_info" => $page_info,
            "page_url" => "/library/index"
        ]);
    }

    public function actionDetail($id){
        $id = intval($id);
        if(!$id){
            return $this->goHome();
        }
        $book_info = Book::find()->where(['id' => $id])->one();
        if(!$book_info){
            return $this->goHome();
        }
        $data = [];
        $author = json_decode($book_info['creator'],true);
        $data['name'] = DataHelper::encode($book_info['name']);
        $data['title'] = DataHelper::encode($book_info['subtitle']);
        $data['summary'] = nl2br( DataHelper::encode($book_info['summary']) );
        $data['publish_date'] = $book_info['publish_date'];
        $data['author'] = implode(" ~ ",$author);
        $data['tags'] = explode(",",$book_info['tags']);
        $data['image_url'] = $book_info['origin_image_url'];

        return $this->render("detail",[
            "info" => $data
        ]);
    }


    public function actionOps($id){
        $id = intval($id);
        $act = trim( $this->post("act","online") );
        if( !$id ){
            return $this->renderJSON([],"操作的图书可能不是你的吧!!",-1);
        }
        $book_info = Book::findOne(["id" => $id]);

        if( !$book_info){
            return $this->renderJSON([],"操作的图书可能不是你的吧!!",-1);
        }

        if( $act == "del" ){
            if(!$book_info['status']){
                return $this->renderJSON([],"操作的图书状态不对!!",-1);
            }

            $book_info->status = 0;
        }else{
            $book_info->status = 1;
        }

        $book_info->updated_time = date("Y-m-d H:i:s");
        $book_info->update(0);
        return $this->renderJSON([],"操作成功!!");
    }

}