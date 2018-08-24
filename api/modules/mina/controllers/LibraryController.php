<?php

namespace api\modules\mina\controllers;

use api\modules\mina\controllers\common\BaseMinaController;
use common\components\HttpClient;
use common\models\library\Book;

class LibraryController extends BaseMinaController {
    public function actionScan(){
		$type = trim($this->post("type","EAN_13"));
		$code = trim($this->post("isbn"));

		if(!$type || !$code){
			return $this->renderJSON([],"请输入参数type 和 isbn",-1);
		}
		$book_info = Book::find()->where(['isbn' => $code])->one();
		if( $book_info){
			return $this->renderJSON([
				"name" => $book_info['subtitle'],
				"summary" => $book_info['summary'],
				"origin_image_url" => $book_info['origin_image_url'],
				"isbn" => $book_info['isbn']
			]);
		}
		$ret = $this->doubanApi($code,$type);

		if(!$ret){
			return $this->renderJSON([],"无法从豆瓣获取数据信息",-1);
		}

		return $this->renderJSON([
			"name" => $ret['subtitle'],
			"summary" => $ret['summary'],
			"origin_image_url" => $ret['origin_image_url'],
			"isbn" => $code
		]);
	}

	private function doubanApi($isbn,$type='EAN_13'){
		$ret = [];
		$uri="https://api.douban.com/v2/book/isbn/:{$isbn}";
		$data = HttpClient::get( $uri );
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
