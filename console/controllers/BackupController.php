<?php

namespace console\controllers;

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
		foreach( $db_names as $db_name){
			$filename = $db_name."_".date("Y-m-d").".sql";
			$command = "cd /data/www/backup/ && /usr/bin/mysqldump -u{$mysql_user}".($mysql_passwd?"  -p{$mysql_passwd}":" ").  " {$db_name} --skip-lock-tables > {$filename}";
			exec($command);
			$this->echoLog("backp mysql:".$command);

			$command = "cd /data/www/backup/ && tar -zcf {$filename}.tar.gz {$filename} && rm {$filename}";
			exec($command);
			$this->echoLog("tar backup_mysql:".$command);
		}


    }
} 