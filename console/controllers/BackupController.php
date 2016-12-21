<?php
namespace console\controllers;

use common\components\QiniuService;

/**
 * 备份
 */
class BackupController extends  BaseController {

    /**
     * 备份数据库
	 * dream_blog dream_log
     */
    public function actionMysql(){

		$config_mysql = \Yii::$app->components['blog'];
		$mysql_user = $config_mysql['username'];
		$mysql_passwd = $config_mysql['password'];
		$db_names = [ "dream_blog","dream_log" ];
		$backup_files = [];
		$backup_dir = "/data/www/backup/";
		foreach( $db_names as $db_name){
			$filename = $db_name."_".date("Y-m-d").".sql";
			$command = "cd {$backup_dir} && /usr/bin/mysqldump -u{$mysql_user}".($mysql_passwd?"  -p{$mysql_passwd}":" ").  " {$db_name} --skip-lock-tables > {$filename}";
			exec($command);
			$this->echoLog("backp mysql:".$command);

			$command = "cd {$backup_dir} && tar -zcf {$filename}.tar.gz {$filename} && rm {$filename}";
			exec($command);
			$this->echoLog("tar backup_mysql:".$command);
			$backup_files[] = [
				'path' => "{$backup_dir}{$filename}.tar.gz",
				'name' => "{$filename}.tar.gz"
			];
		}

		if( $backup_files ){
			//直接放到七牛网站上去
			foreach( $backup_files as $_back_file ){
				$ret = QiniuService::uploadFile( $_back_file['path'],$_back_file['name'],'backup' );
				if( !$ret ){
					$this->echoLog( QiniuService::getLastErrorMsg() );
				}
			}
		}



    }

} 