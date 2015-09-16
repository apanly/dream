<?php

namespace api\controllers;

use api\controllers\common\AuthController;
use common\components\HttpLib;
use common\models\library\Book;
use Yii;

class LibraryController extends AuthController{

    public function actionScan(){
        $type = trim($this->post("type","EAN_13"));
        $code = trim($this->post("isbn"));
        $date_now = date("Y-m-d H:i:s");
        $this->recode("test");
        if(!$type || !$code){
            return $this->renderJSON([],"请输入参数type 和 isbn",-1);
        }
        $book_info = Book::find()->where(['isbn' => $code])->one();
        if($book_info){
            return $this->renderJSON([
                "name" => $book_info['subtitle'],
                "origin_image_url" => $book_info['origin_image_url'],
                "isbn" => $book_info['isbn']
            ]);
        }
        $ret = $this->doubanApi($code,$type);
        if(!$ret){
            return $this->render([],"无法从豆瓣获取数据信息",-1);
        }

        $model_book = new Book();
        $model_book->isbn = $ret['isbn'];
        $model_book->bartype = $ret['bartype'];
        $model_book->name = $ret['name'];
        $model_book->subtitle = $ret['subtitle'];
        $model_book->creator = json_encode($ret['creator']);
        $model_book->binding = $ret['binding'];
        $model_book->pages = $ret['pages'];
        $model_book->publish_date = date("Y-m-d",strtotime($ret['publish_date']));
        $model_book->publishing_house = $ret['publishing_house'];
        $model_book->tags = $ret['tags'];
        $model_book->summary = $ret['summary'];
        $model_book->origin_image_url = $ret['origin_image_url'];
        $model_book->status = 0;
        $model_book->updated_time = $date_now;
        $model_book->created_time = $date_now;
        $model_book->save(0);

        return $this->renderJSON([
            "name" => $ret['subtitle'],
            "origin_image_url" => $ret['origin_image_url'],
            "isbn" => $code
        ]);
    }


    private function doubanApi($isbn,$type='EAN_13'){
        $ret = [];
        $uri="https://api.douban.com/v2/book/isbn/:{$isbn}";
        $http = new Httplib();
        $http_res = $http->get($uri);
        $data=$http_res['body'];
        $data=json_decode($data,true);
        if($data){
            $ret['isbn']=$isbn;
            $ret['bartype']=$type;
            $ret['name']='';
            $ret['subtitle']='';
            $ret['summary']="";
            $ret['tags']="";
            $ret['creator']="";
            $ret['binding']='';
            $ret['pages']="";
            $ret['publishing_house']="";
            $ret['publish_date']="";
            $ret['origin_image_url']='';
            if(!isset($data['code'])){
                $ret['name']=$data['origin_title'];
                $ret['subtitle']=$data['title'];
                $tags=$data['tags'];
                foreach($tags as $item){
                    $ret['tags'][]=$item['name'];
                }
                $ret['tags']=implode(",",$ret['tags']);
                $ret['summary']=$data['summary'];
                $ret['creator']=$data['author'];
                $ret['binding']=$data['binding'];
                $ret['pages']=$data['pages'];
                $ret['publishing_house']=$data['publisher'];
                $ret['publish_date']=$data['pubdate'];
                $ret['origin_image_url']=$data['images']['large'];
            }
        }
        return $ret;
    }
}