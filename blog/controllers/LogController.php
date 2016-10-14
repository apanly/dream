<?php

namespace blog\controllers;

use blog\controllers\common\BaseController;
use common\components\UtilHelper;
use common\models\applog\AccessLogs;
use common\models\posts\Posts;
use Yii;


class LogController extends BaseController{
    public function actionAdd(){
        $referer = $this->get("referer","");
        $target_url = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"";
        if( $target_url ){
			$blog_id = 0;
			preg_match("/\/default\/(\d+)(.html)?/",$target_url,$matches);
			if( $matches && count( $matches ) >= 2  ){
				$blog_id = $matches[1];
			}

        	$uuid = $this->getUUID();
        	$uuid = ltrim($uuid,"{");
        	$uuid = rtrim($uuid,"}");

            $model_ac_log = new AccessLogs();
            $model_ac_log->referer = $referer;
            $model_ac_log->target_url = $target_url;
			$model_ac_log->blog_id = $blog_id;
            $model_ac_log->user_agent = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:"";
            $model_ac_log->ip = UtilHelper::getClientIP();
			$model_ac_log->uuid = $uuid;
            $model_ac_log->created_time = date("Y-m-d H:i:s");
            $model_ac_log->save();

			/*更新文章阅读量*/
			if( $blog_id ){
				$blog_info = Posts::findOne([ 'id' => $blog_id ]);
				if( $blog_info ){
					$blog_info->view_count += 1;
					$blog_info->update(0);
				}
			}

        }



    }

}