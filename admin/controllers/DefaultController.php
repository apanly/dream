<?php

namespace admin\controllers;

use admin\controllers\common\BaseController;
use common\components\phpanalysis\FenCiService;
use common\models\library\Book;
use common\models\posts\Posts;
use common\models\stat\StatAccess;
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

        /*画图*/
        $date_from = date("Y-m-d",strtotime("-30 day"));
        $date_to = date("Y-m-d");
        $stat_access_list = StatAccess::find()
            ->where(['>=',"date",$date_from])
            ->andWhere(['<=',"date",$date_to])
            ->orderBy("date asc")
            ->asArray()
            ->all();

        $data_access = [
            "categories" => [],
            "series" => [
                [
                    'name' => 'IP总数',
                    'data' => []
                ],
                [
                    'name' => '访问量',
                    'data' => []
                ]
            ]
        ];
        if( $stat_access_list ){
            foreach( $stat_access_list as $_item ){
                $data_access['categories'][] = $_item['date'];
                $data_access['series'][0]['data'][] = intval( $_item['total_ip_number'] );
                $data_access['series'][1]['data'][] = intval( $_item['total_number'] );
            }
        }


        return $this->render("index",[
            "stat" =>$data,
            "data_access" => $data_access
        ]);
    }


}