<?php

namespace admin\controllers;

use admin\components\AdminUrlService;
use admin\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\library\Book;
use common\models\posts\Posts;
use common\models\stat\StatAccess;
use common\models\stat\StatBlog;
use common\models\stat\StatDailyAccessSource;
use common\models\stat\StatDailyBrowser;
use common\models\stat\StatDailyDevice;
use common\models\stat\StatDailyOs;
use common\service\GeoService;
use common\service\GlobalUrlService;
use Yii;


class DefaultController extends BaseController {
    public function actionIndex(){
        $data = [
			'summary' => []
        ];

        $total_posts = Posts::find()->count();
        $total_valid_posts = Posts::find()->where(['status' => 1])->count();

        $data['posts'] = [
            "total" => $total_posts,
            "total_valid" => $total_valid_posts
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
                    'name' => 'PV',
                    'data' => []
                ],
				[
					'name' => 'UV',
					'data' => []
				],
                [
                    'name' => 'IP',
                    'data' => []
                ]
            ]
        ];
        if( $stat_access_list ){
            foreach( $stat_access_list as $_item ){
                $data_access['categories'][] = $_item['date'];
				$data_access['series'][0]['data'][] = intval( $_item['total_number'] );
				$data_access['series'][1]['data'][] = intval( $_item['total_uv_number'] );
                $data_access['series'][2]['data'][] = intval( $_item['total_ip_number'] );
                if( $_item['date'] >= date("Y-m-d",strtotime("-7 days") ) ){
					$data['summary'][] = [
						'date' => $_item['date'],
						'total_number' => $_item['total_number'],
						'total_ip_number' => $_item['total_ip_number'],
						'total_uv_number' => $_item['total_uv_number'],
						'total_new_user_number' => $_item['total_new_user_number'],
						'total_returned_user_number' => $_item['total_returned_user_number'],
						'avg_pv_per_uv' => $_item['avg_pv_per_uv']
					];
				}
            }
            $data['summary'] = array_reverse( $data['summary'] );
        }




        return $this->render("index",[
            "stat" =>$data,
            "data_access" => $data_access,
			'custom_date' => $this->getCustomDate()
        ]);
    }

	public function actionTopSearch(){
    	$data = [];
		$kw = trim( $this->get("q",'') );
		$query = Posts::find();
		$query->andWhere( ['LIKE', 'title', '%' . strtr($kw, ['%' => '\%', '_' => '\_', '\\' => '\\\\']) . '%', false] );
		$list = $query->orderBy([ 'view_count' => SORT_DESC  ])->asArray()->limit(10)->all();
		if( $list ){
			foreach( $list as $_item ){
				$data[] = [
					'id' => $_item['id'],
					'title' => DataHelper::encode(  $_item['title'] ),
					'url' => AdminUrlService::buildUrl("/posts/set",[ 'id' => $_item['id'] ])
				];
			}
		}
		return $this->renderJSON( $data );
	}

	private function getCustomDate(){
		return [
			'今天' =>  [
				'date_from' => date("Y-m-d"),
				'date_to' => date("Y-m-d")
			],
			'近7天' =>  [
				'date_from' => date("Y-m-d",strtotime("-7 days") ),
				'date_to' => date("Y-m-d")
			],
			'近15天' =>  [
				'date_from' => date("Y-m-d",strtotime("-15 days") ),
				'date_to' => date("Y-m-d")
			],
			'近30天' =>  [
				'date_from' => date("Y-m-d",strtotime("-30 days") ),
				'date_to' => date("Y-m-d")
			],
			'本周' =>  [
				'date_from' => date("Y-m-d",strtotime("-".(date("N")-1)." days") ),
				'date_to' => date("Y-m-d")
			],
			'本月' =>  [
				'date_from' => date("Y-m-01" ),
				'date_to' => date("Y-m-d")
			]
		];
	}
}