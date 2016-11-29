<?php

namespace console\modules\blog\controllers;

use common\models\applog\AccessLogs;
use common\models\posts\Posts;
use common\models\stat\StatAccess;
use common\models\stat\StatBlog;
use common\models\stat\StatDailyUuid;
use console\modules\blog\Blog;
use common\service\health\HealthService;

class Stat_dailyController extends Blog{

    /**
     * 每天统计一次就够了
     * 10 3 * * *
     */
    public function actionBlog( $date = ''){
        $date = $date?$date:date("Y-m-d",strtotime("-1 day"));
        $date_now = date("Y-m-d H:i:s");
        if( !preg_match("/^\d{4}-\d{2}-\d{2}$/",$date) ){
            return $this->echoLog("date{$date} is illegal!!");
        }

        $this->echoLog( "stat_blog date is {$date}" );
        $info = StatBlog::findOne( [ 'date' => $date ] );
        if( $info ){
            $model_stat_blog = $info;
        }else{
            $model_stat_blog = new StatBlog();
            $model_stat_blog->date = $date;
            $model_stat_blog->created_time = $date_now;
        }

        /*统计已发布文章数量，未发布文章数量，原创文章数量，热门文章数量*/
        $stat_status = Posts::find()->select(['status','count(*) as num'])
            ->groupBy("status")->asArray()->all();
        $stat_status = array_column($stat_status,null,"status");
        $model_stat_blog->total_post_number = ($stat_status && isset($stat_status[1]))?$stat_status[1]['num']:0;
        $model_stat_blog->total_unpost_number = ($stat_status && isset($stat_status[0]))?$stat_status[0]['num']:0;

        $stat_hot = Posts::find()->where(['hot' => 1])->count();
        $model_stat_blog->total_hot_number = $stat_hot?$stat_hot:0;

        $stat_original = Posts::find()->where(['original' => 1])->count();
        $model_stat_blog->total_original_number = $stat_original?$stat_original:0;

        $stat_today = Posts::find()
            ->where(['>=' ,'created_time',date("Y-m-d 00:00:00",strtotime($date) )])
            ->andWhere(['<=' ,'created_time',date("Y-m-d 23:59:59",strtotime($date) )])
            ->count();

        $model_stat_blog->today_post_number = $stat_today?$stat_today:0;

        $model_stat_blog->updated_time = $date_now;
        $model_stat_blog->save( 0 );


    }

    public function actionAccess( $date = '' ){
        $date = $date?$date:date("Y-m-d");
        $date_now = date("Y-m-d H:i:s");
        if( !preg_match("/^\d{4}-\d{2}-\d{2}$/",$date) ){
            return $this->echoLog("date{$date} is illegal!!");
        }

        $this->echoLog( "stat_access date is {$date}" );

        $info = StatAccess::findOne( ['date' => $date ] );
        if( $info ){
            $model_stat_access = $info;
        }else{
            $model_stat_access = new StatAccess();
            $model_stat_access->date = $date;
            $model_stat_access->created_time = $date_now;
        }

        $stat_count = AccessLogs::find()
            ->where(['>=' ,'created_time',date("Y-m-d 00:00:00",strtotime($date) )])
            ->andWhere(['<=' ,'created_time',date("Y-m-d 23:59:59",strtotime($date) )])
            ->count();
        $model_stat_access->total_number = $stat_count?$stat_count:0;

        $stat_ip_count = AccessLogs::find()
            ->where(['>=' ,'created_time',date("Y-m-d 00:00:00",strtotime($date) )])
            ->andWhere(['<=' ,'created_time',date("Y-m-d 23:59:59",strtotime($date) )])
            ->groupBy("ip")
            ->count();
        $model_stat_access->total_ip_number = $stat_ip_count?$stat_ip_count:0;

		$stat_uuid = AccessLogs::find()
			->select([ 'uuid' ])
			->where(['>=' ,'created_time',date("Y-m-d 00:00:00",strtotime($date) )])
			->andWhere(['<=' ,'created_time',date("Y-m-d 23:59:59",strtotime($date) )])
			->groupBy("uuid")
			->asArray()->all();

		$model_stat_access->total_uv_number = $stat_uuid?count( $stat_uuid ):0;

		if( $stat_uuid ){
			$stat_returned_user = StatDailyUuid::find()
				->select([ 'uid' ])
				->where([ 'uuid' =>  array_column( $stat_uuid,'uuid' ) ])
				->andWhere([ '<','date',date("Ymd",strtotime($date)) ])
				->groupBy([ 'uuid' ])
				->all();
			$model_stat_access->total_returned_user_number = $stat_returned_user?count($stat_returned_user):0;
			$model_stat_access->total_new_user_number = $model_stat_access->total_uv_number - $model_stat_access->total_returned_user_number;
		}

		if( $model_stat_access->total_number && $model_stat_access->total_uv_number){
			$model_stat_access->avg_pv_per_uv = sprintf("%.2f", ($model_stat_access->total_number/ $model_stat_access->total_uv_number) );
		}

        $model_stat_access->updated_time = $date_now;
        return $model_stat_access->save( 0 );
    }
}