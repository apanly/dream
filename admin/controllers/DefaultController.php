<?php

namespace admin\controllers;

use admin\controllers\common\BaseController;
use common\components\phpanalysis\FenCiService;
use common\models\library\Book;
use common\models\posts\Posts;
use Yii;


class DefaultController extends BaseController
{
    public function actionIndex(){

        $data = [
            "posts" => [],
            "library" => []
        ];

        $total_posts = Posts::find()->count();
        $total_valid_posts = Posts::find()->where(['status' => 1])->count();

        $today_date = date("Y-m-d");
        $today_post = Posts::find()
            ->where([">=","created_time",$today_date." 00:00:00"])
            ->andWhere(["<=","created_time",$today_date." 23:23:59"])
            ->count();

        $data['posts'] = [
            "total" => $total_posts,
            "total_valid" => $total_valid_posts,
            "today" => $today_post
        ];


        $total_book = Book::find()->count();
        $total_valid_book = Book::find()->where(['status' => 1])->count();

        $data['library'] = [
            "total" => $total_book,
            "total_valid" => $total_valid_book
        ];

        return $this->render("index",[
            "stat" =>$data
        ]);
    }


}