<?php

namespace admin\controllers;

use admin\controllers\common\BaseController;
use common\components\phpanalysis\FenCiService;
use common\models\library\Book;
use common\models\posts\Posts;
use common\models\stat\StatAccess;
use common\models\stat\StatBlog;
use common\models\stat\StatDailyAccessSource;
use common\models\stat\StatDailyBrowser;
use common\models\stat\StatDailyDevice;
use common\models\stat\StatDailyOs;
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
                    'name' => '访问量',
                    'data' => []
                ],
                [
                    'name' => 'IP总数',
                    'data' => []
                ]
            ]
        ];
        if( $stat_access_list ){
            foreach( $stat_access_list as $_item ){
                $data_access['categories'][] = $_item['date'];
                $data_access['series'][1]['data'][] = intval( $_item['total_ip_number'] );
                $data_access['series'][0]['data'][] = intval( $_item['total_number'] );
            }
        }

        $stat_blog_list = StatBlog::find()
            ->where(['>=',"date",$date_from])
            ->andWhere(['<=',"date",$date_to])
            ->orderBy("date asc")
            ->asArray()
            ->all();
        $data_blog = [
            "categories" => [],
            "series" => [
                [
                    'name' => '已发布',
                    'data' => []
                ],
                [
                    'name' => '待发布',
                    'data' => []
                ]
            ]
        ];

        if( $stat_blog_list ){
            foreach( $stat_blog_list as $_item ){
                $data_blog['categories'][] = $_item['date'];
                $data_blog['series'][0]['data'][] = intval( $_item['total_post_number'] );
                $data_blog['series'][1]['data'][] = intval( $_item['total_unpost_number'] );
            }
        }


        /*今日来源域名*/
        $ignore_source = ["direct","www.vincentguo.cn","m.vincentguo.cn" ];
        $data_source = [
			'series' => [
				[
					'data' => []
				]
			]
		];
		$source_list = StatDailyAccessSource::find()
			->where([ 'date' => date("Ymd") ])
			->andWhere([ 'not in','source',$ignore_source ])
			->orderBy([ 'total_number' => SORT_DESC ])
			->asArray()
			->all();
		if( $source_list ){
			$total_number = array_sum(  array_column($source_list,"total_number") );
			foreach( $source_list as $_item ){
				$data_source['series'][0]['data'][] =[
					'name' => $_item['source'],
					'y' => floatval( sprintf("%.2f", ( $_item['total_number']/ $total_number) * 100 ) ),
					'total_number' => $_item['total_number']
				];
			}
		}
		/*操作系统*/
		$data_client_os = [
			'series' => [
				[
					'data' => []
				]
			]
		];
		$os_list = StatDailyOs::find()
			->where([ 'date' => date("Ymd") ])
			->orderBy([ 'total_number' => SORT_DESC ])
			->asArray()
			->all();
		if( $os_list ){
			$total_number = array_sum(  array_column($os_list,"total_number") );
			foreach( $os_list as $_item ){
				$data_client_os['series'][0]['data'][] =[
					'name' => $_item['client_os'],
					'y' => floatval( sprintf("%.2f", ( $_item['total_number']/ $total_number) * 100 ) ),
					'total_number' => $_item['total_number']
				];
			}
		}

		/*浏览器统计*/
		$data_client_browser = [
			'series' => [
				[
					'data' => []
				]
			]
		];

		$client_browser_list = StatDailyBrowser::find()
			->where([ 'date' => date("Ymd") ])
			->orderBy([ 'total_number' => SORT_DESC ])
			->asArray()
			->all();
		if( $client_browser_list ){
			$total_number = array_sum(  array_column($client_browser_list,"total_number") );
			foreach( $client_browser_list as $_item ){
				$data_client_browser['series'][0]['data'][] =[
					'name' => $_item['client_browser'],
					'y' => floatval( sprintf("%.2f", ( $_item['total_number']/ $total_number) * 100 ) ),
					'total_number' => $_item['total_number']
				];
			}
		}

		/*设备统计*/
		$data_client_device = [
			'series' => [
				[
					'data' => []
				]
			]
		];

		$client_device_list = StatDailyDevice::find()
			->where([ 'date' => date("Ymd") ])
			->orderBy([ 'total_number' => SORT_DESC ])
			->asArray()
			->all();
		if( $client_device_list ){
			$total_number = array_sum(  array_column($client_device_list,"total_number") );
			foreach( $client_device_list as $_item ){
				$data_client_device['series'][0]['data'][] =[
					'name' => $_item['client_device'],
					'y' => floatval( sprintf("%.2f", ( $_item['total_number']/ $total_number) * 100 ) ),
					'total_number' => $_item['total_number']
				];
			}
		}

        return $this->render("index",[
            "stat" =>$data,
            "data_access" => $data_access,
            "data_blog" => $data_blog,
            "data_client_os" => $data_client_os,
			'data_source' => $data_source,
			'data_client_browser' => $data_client_browser,
			'data_client_device' => $data_client_device
        ]);
    }


}