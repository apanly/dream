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
            "posts" => [],
            "library" => [],
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


        $date_int = date("Ymd");
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
			->where([ 'date' => $date_int ])
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
			->where([ 'date' => $date_int ])
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
			->where([ 'date' => $date_int ])
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
			->where([ 'date' => $date_int ])
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

		//环境变量
//		$db_target = Yii::$app->get("blog");
//		$db_target->createCommand("SELECT version() as version,user() as user")->queryOne();
		$env = [
			'sys' =>  [
				'服务器' => $_SERVER["SERVER_SOFTWARE"], //获取服务器标识的字串
				'PHP版本' => PHP_VERSION, //获取PHP服务器版本
				'操作系统' => php_uname(), //获取系统类型及版本号
				'端口' => $_SERVER['SERVER_PORT'], //获取服务器Web端口
				'上传限制' => ini_get("file_uploads") ? ini_get("upload_max_filesize") : "Disabled"
			],
		];

        return $this->render("index",[
            "stat" =>$data,
            "data_access" => $data_access,
            "data_blog" => $data_blog,
            "data_client_os" => $data_client_os,
			'data_source' => $data_source,
			'data_client_browser' => $data_client_browser,
			'data_client_device' => $data_client_device,
			'env' => $env
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
}