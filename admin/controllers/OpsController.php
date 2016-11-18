<?php

namespace admin\controllers;

use admin\components\AdminUrlService;
use admin\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\applog\AppLogs;
use common\models\ops\ReleaseQueue;
use Yii;


class OpsController extends BaseController{

	private $release_status_mapping = [
		'-2' => [ 'title' => '待运行','class' => 'color-gray' ],
		'-1' => [ 'title' => '运行中','class' => 'color-orange' ],
		'0' => [ 'title' => '发布失败','class' => 'color-danger' ],
		'1' => [ 'title' => '发布成功','class' => 'color-success' ],
	];
	public function actionIndex(){

		$release_status_mapping = $this->release_status_mapping;
		$p = intval( $this->get("p",1) );
		if(!$p){
			$p = 1;
		}
		$data = [];
		$query = ReleaseQueue::find();
		$total_count = $query->count();
		$offset = ($p - 1) * $this->page_size;
		$list = $query->orderBy([ 'id' => SORT_DESC ])
			->offset($offset)
			->limit( $this->page_size )
			->all();

		$page_info = DataHelper::ipagination([
			"total_count" => $total_count,
			"page_size" => $this->page_size,
			"page" => $p,
			"display" => 10
		]);
		if( $list ){
			foreach( $list as $_item ){
				$data[] = [
					'id' => $_item['id'],
					'repo' => $_item['repo'],
					'note' => $_item['note'],
					'status' => $release_status_mapping[ $_item['status'] ],
					'created_time' => $_item['created_time']
				];
			}
		}

		return $this->render("index",[
			"data" => $data,
			"page_info" => $page_info,
			'search_conditions' => []
		]);
	}

    private $log_type_mapping = [
        1 => 'app-blog',
        2 => 'app-js',
		3 => 'app-console'
    ];

    public function actionError(){
        $type = intval( $this->get("type",0) );
        $log_type_mapping = $this->log_type_mapping;

        $p = intval( $this->get("p",1) );
        if(!$p){
            $p = 1;
        }

        $data = [];
        $query = AppLogs::find();

        if( isset( $log_type_mapping[ $type ] ) ){
            $query->andWhere([ 'app_name' =>  $log_type_mapping[ $type ] ]);
        }

        $total_count = $query->count();
        $offset = ($p - 1) * $this->page_size;
        $access_list = $query->orderBy("id desc")
            ->offset($offset)
            ->limit( $this->page_size )
            ->all();

        $page_info = DataHelper::ipagination([
            "total_count" => $total_count,
            "page_size" => $this->page_size,
            "page" => $p,
            "display" => 10
        ]);

        if($access_list){
            $idx = 1;
            foreach($access_list as $_item_access ){
                $data[] = [
                    'idx' =>  $idx,
                    'app_name' => $_item_access['app_name'],
                    'request_uri' => $_item_access['request_uri'],
                    'content' => ( mb_strlen($_item_access['content'],"utf-8") > 150)?  DataHelper::encode( mb_substr($_item_access['content'],0,150,"utf-8") ):DataHelper::encode( $_item_access['content'] ),
                    'ua' => $_item_access['ua'],
                    'ip' => $_item_access['ip'],
                    'cookies' => DataHelper::encode( $_item_access['cookies']),
                    'created_time' => $_item_access['created_time']
                ];
                $idx++;
            }
        }

        $search_conditions = [
            'type' => $type
        ];

        return $this->render("error",[
            "data" => $data,
            "page_info" => $page_info,
            'search_conditions' => $search_conditions,
            'log_type_mapping' => $log_type_mapping
        ]);
    }

    public function actionRelease(){
		$ops_repo_mapping = Yii::$app->params['ops_repo'];
    	if( Yii::$app->request->isGet ){
    		$html = $this->renderPartial("release",[
				'repo_mapping' => $ops_repo_mapping
			]);
    		return $this->renderJSON([ 'form_wrap' => $html ]);
		}

		$repo = trim( $this->post("repo") );
		$note = trim( $this->post("note") );

		if( !isset( $ops_repo_mapping[ $repo ] ) ){
			return $this->renderJSON([],"请选择仓库~~",-1);
		}

		if( mb_strlen( $note,"utf-8" ) < 5  ){
			return $this->renderJSON([],"请输入不少于5个字符的描述~~",-1);
		}

		$has_not_complate_task = ReleaseQueue::find()->where([ 'status' => -2 ,'repo' => $repo ])->count();
		if( $has_not_complate_task ){
			return $this->renderJSON([],"目前已有一个未运行同仓库的任务，请稍等~~",-1);
		}

		$queue = new ReleaseQueue();
		$queue->uid = $this->current_user['uid'];
		$queue->repo = $repo;
		$queue->note = $note;
		$queue->status = -2;
		$queue->created_time = $queue->updated_time = date("Y-m-d H:i:s");
		if( $queue->save(0) ){
			return $this->renderJSON([ 'url' => AdminUrlService::buildUrl("/ops/queue",[ 'id' => $queue->id ]) ],'操作成功~~');
		}

		return $this->renderJSON([],"系统繁忙，请稍后再试~~",-1);
	}

	public function actionQueue(){
    	$id = intval( $this->get("id",0) );
    	$reback_url = AdminUrlService::buildUrl("/ops/index");
    	if( !$id ){
			return $this->redirect( $reback_url );
		}

		$info = ReleaseQueue::find()->where([ 'id' => $id ])->one();
    	if( !$info ){
			return $this->redirect( $reback_url );
		}

		$release_status_mapping = $this->release_status_mapping;
		$cmds = [];
		$logs = @json_decode( $info['content'],true);
		if($logs){
			foreach($logs as $key => $cmd){
				if($key == "fail_reason"){
					continue;
				}
				$cmds[$key] = str_replace("\r\n","<br/>",$cmd);
			}
		}

		$data = [
			'repo' => $info['repo'],
			'status' => $info['status'],
			'status_info' => $release_status_mapping[ $info['status'] ]
		];
		return $this->render("queue",[
			'info' => $data,
			'cmds' => $cmds,
			'fail_reason' => isset($logs['fail_reason'])?$logs['fail_reason']:''
		]);
	}
}