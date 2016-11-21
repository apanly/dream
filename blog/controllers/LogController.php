<?php

namespace blog\controllers;

use blog\controllers\common\BaseController;
use common\components\UtilHelper;
use common\models\applog\AccessLogs;
use common\models\posts\Posts;
use apanly\BrowserDetector\Browser;
use apanly\BrowserDetector\Os;
use apanly\BrowserDetector\Device;
use Yii;


class LogController extends BaseController{
    public function actionAdd(){
        $referer = trim( $this->get("referer","") );
        $screen = trim( $this->get("screen","") );
        $target_url = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"";
        if( $target_url ){
			$blog_id = 0;
			preg_match("/\/default\/(\d+)(.html)?/",$target_url,$matches);
			if( $matches && count( $matches ) >= 2  ){
				$blog_id = $matches[1];
			}

			$tmp_source = 'direct';
			if( $referer ){
				$tmp_source = parse_url( $referer ,PHP_URL_HOST );
				if( stripos($tmp_source,"www.google.") !== false ){
					$tmp_source = "www.google.com";
				}
			}

        	$uuid = $this->getUUID();
        	$uuid = ltrim($uuid,"{");
        	$uuid = rtrim($uuid,"}");

            $model_ac_log = new AccessLogs();
            $model_ac_log->referer = $referer;
            $model_ac_log->target_url = $target_url;
			$model_ac_log->blog_id = $blog_id;
			$model_ac_log->source = $tmp_source?$tmp_source:'';
            $model_ac_log->user_agent = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:"";

            if( $model_ac_log->user_agent ){
				$tmp_browser = new Browser( $model_ac_log->user_agent );
				$tmp_os = new Os( $model_ac_log->user_agent );
				$tmp_device = new Device( $model_ac_log->user_agent );
				$model_ac_log->client_browser = $tmp_browser->getName()?$tmp_browser->getName():'';
				$model_ac_log->client_browser_version = $tmp_browser->getVersion()?$tmp_browser->getVersion():'';
				$model_ac_log->client_os = $tmp_os->getName()?$tmp_os->getName():'';
				$model_ac_log->client_os_version = $tmp_os->getVersion()?$tmp_os->getVersion():'';
				$model_ac_log->client_device = $tmp_device->getName()?$tmp_device->getName():'';
				if( $model_ac_log->client_device == "unknown" && UtilHelper::isPC() ){
					$model_ac_log->client_device = "pc";
				}
			}
            $model_ac_log->ip = UtilHelper::getClientIP();
			$model_ac_log->uuid = $uuid;

			if( $screen ){
				list( $client_width, $client_height ) = explode("/",$screen );
				if( $client_width ){
					$model_ac_log->client_width = $client_width;
				}
				if( $client_height ){
					$model_ac_log->client_height = $client_height;
				}
			}
			$model_ac_log->created_time_min = date("Y-m-d H:i");
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