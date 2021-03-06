<?php

namespace blog\controllers;

use blog\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\library\Book;
use common\service\Constant;
use common\service\GlobalUrlService;
use Yii;
use yii\helpers\Url;


class LibraryController extends BaseController{
    public function actionIndex(){
        $this->setTitle("图书馆");
        $p = intval($this->get("p", 1));
        if (!$p) {
            $p = 1;
        }

        $data = [];
        $pagesize = 20;
        $offset   = ($p - 1) * $pagesize;
        $query  = Book::find()->where(['status' => 1]);
        $total_count = $query->count();

        $books = $query->orderBy("id desc")
            ->offset($offset)
            ->limit($pagesize)
            ->all();

        if ($books) {
            foreach ($books as $_book) {
                $tmp_title  = DataHelper::encode($_book['subtitle']);
                $tmp_title  = mb_substr($tmp_title, 0, 10, "utf-8");
                $tmp_author = @json_decode($_book['creator'], true);
                $tmp_author = $tmp_author ? $tmp_author[0] : '&nbsp;';
                if (stripos($tmp_author, "(") !== false) {
                    $tmp_author = substr($tmp_author, 0, stripos($tmp_author, "("));
                }
                if (stripos($tmp_author, "（") !== false) {
                    $tmp_author = substr($tmp_author, 0, stripos($tmp_author, "（"));
                }

                $tmp_small_pic_url = GlobalUrlService::buildPic1Static($_book['image_url'],['h' => 200]);

                switch( $_book['read_status'] ){
                    case 1:
                        $tmp_icon_imager_url = GlobalUrlService::buildStaticUrl("/images/web/readed.png");
                        break;
                    case -1:
                        $tmp_icon_imager_url = GlobalUrlService::buildStaticUrl("/images/web/reading.png");
                        break;
                    default:
                        $tmp_icon_imager_url = GlobalUrlService::buildStaticUrl("/images/web/unread.png");
                        break;
                }

                $data[] = [
                    'id'  => $_book['id'],
                    'short_title' => $tmp_title,
                    "title"  => DataHelper::encode($_book['subtitle']),
                    'author'  => $tmp_author ? $tmp_author : "&nbsp;",
                    'imager_url'  => $tmp_small_pic_url,
                    'icon_imager_url'  => $tmp_icon_imager_url,
                    'view_url'    => Url::toRoute(["/library/info", "id" => $_book["id"]])
                ];
            }
        }

        $page_info = DataHelper::ipagination([
            "total_count" => $total_count,
            "page_size"    => $pagesize,
            "page"        => $p,
            "display"     => 5
        ]);

        return $this->render("index", [
            "data"      => $data,
            "page_info" => $page_info
        ]);
    }

    public function actionDetail($id){
        return $this->redirect(Url::toRoute(["/library/info", "id" => $id]), 301);
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

        $data  = [];
        $author = json_decode($book_info['creator'], true);
        $data['name']  = DataHelper::encode($book_info['name']);
        $data['title']  = DataHelper::encode($book_info['subtitle']);
        $data['summary'] = nl2br(DataHelper::encode($book_info['summary']));
        $data['publish_date'] = $book_info['publish_date'];
        $data['author'] = implode(" ~ ", $author);
        $data['tags']  = explode(",", $book_info['tags']);
        $data['read_status_info']  = Constant::$read_desc[ $book_info['read_status'] ];
        $data['image_url']  = GlobalUrlService::buildPic1Static($book_info['image_url'],['w' => 500]);
        $data['isbn'] = $book_info['isbn'];

        $prev_info = Book::find()
            ->where(["<", "id", $id])
            ->andWhere(['status' => 1])
            ->orderBy("id desc")
            ->one();

        $next_info = Book::find()
            ->where([">", "id", $id])
            ->andWhere(['status' => 1])
            ->orderBy("id asc")
            ->one();

        $this->setTitle($book_info['subtitle']);

        return $this->render("detail", [
            "info"      => $data,
            "prev_info" => $prev_info,
            "next_info" => $next_info
        ]);
    }
}