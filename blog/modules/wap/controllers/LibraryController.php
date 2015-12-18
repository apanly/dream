<?php

namespace blog\modules\wap\controllers;

use blog\components\UrlService;
use blog\modules\wap\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\library\Book;
use common\service\GlobalUrlService;
use Yii;


class LibraryController extends BaseController{
    private $page_size = 10;

    public function actionIndex(){
        $this->setTitle("郭大帅哥的图书馆");
        $data = $this->search();
        return $this->render("index", [
            "book_list" => $this->buildItem($data),
            "has_next"  => (count($data) < $this->page_size) ? false : true
        ]);
    }

    public function actionDetail($id){
        return $this->redirect(UrlService::buildWapUrl("/library/info", ["id" => $id]), 301);
    }

    public function actionInfo($id){

        $id = intval($id);
        if (!$id) {
            return $this->goLibraryHome();
        }
        $book_info = Book::find()->where(['id' => $id, 'status' => 1])->one();
        if (!$book_info) {
            return $this->goLibraryHome();
        }

        $this->setTitle($book_info['subtitle'] . " - 郭大帅哥的图书馆");

        $data = [];
        $author  = json_decode($book_info['creator'], true);
        $data['name'] = DataHelper::encode($book_info['name']);
        $data['title']  = DataHelper::encode($book_info['subtitle']);
        $data['summary'] = nl2br(DataHelper::encode($book_info['summary']));
        $data['publish_date'] = $book_info['publish_date'];
        $data['author'] = implode(" ~ ", $author);
        $data['tags'] = explode(",", $book_info['tags']);
        $data['image_url'] = GlobalUrlService::buildPic1Static($book_info['image_url']);


        return $this->render("info", [
            "info" => $data,
        ]);
    }

    public function actionSearch(){
        $p    = intval($this->get("p", 2));
        $data = $this->search(['p' => $p]);
        return $this->renderJSON([
            'html'     => $this->buildItem($data),
            "has_next" => (count($data) < $this->page_size) ? false : true,
            "has_data" => $data ? true : false
        ]);
    }

    private function search($params = []){
        $p      = isset($params['p']) ? $params['p'] : 1;
        $offset = ($p - 1) * $this->page_size;

        $query = Book::find()->where(['status' => 1]);
        $books = $query->orderBy("id desc")
            ->offset($offset)
            ->limit($this->page_size)
            ->all();

        $data = [];
        if ($books) {
            foreach ($books as $_book) {
                $tmp_author = @json_decode($_book['creator'], true);
                $tmp_author = $tmp_author ? $tmp_author[0] : '&nbsp;';
                if (stripos($tmp_author, "(") !== false) {
                    $tmp_author = substr($tmp_author, 0, stripos($tmp_author, "("));
                }
                if (stripos($tmp_author, "（") !== false) {
                    $tmp_author = substr($tmp_author, 0, stripos($tmp_author, "（"));
                }
                $data[] = [
                    "title"      => DataHelper::encode($_book['subtitle']),
                    'author'     => $tmp_author ? $tmp_author : "&nbsp;",
                    'imager_url' => GlobalUrlService::buildPic1Static($_book['image_url']),
                    'view_url'   => UrlService::buildWapUrl("/library/info", ["id" => $_book["id"]])
                ];
            }
        }
        return $data;
    }

    private function buildItem($data){
        return $this->renderPartial("item", [
            "book_list" => $data
        ]);
    }
}