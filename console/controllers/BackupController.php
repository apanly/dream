<?php

namespace console\controllers;

/**
 * 备份
 */
class BackupController extends  BaseController {

    /**
     * 备份数据库
     */
    public function actionMysql(){

        $filename = date("Y-m-d").".sql";
        $config_mysql = \Yii::$app->components['blog'];
        $mysql_user = $config_mysql['username'];
        $mysql_passwd = $config_mysql['password'];
        $db_name = "dream_blog";

        $command = "cd /data/www/backup/ && /usr/bin/mysqldump -u{$mysql_user}".($mysql_passwd?"  -p{$mysql_passwd}":" ").  " {$db_name} --skip-lock-tables > {$filename}";
        exec($command);
        $this->echoLog("backp mysql:".$command);

        $command = "cd /data/www/backup/ && tar -zcf {$filename}.tar.gz {$filename} && rm {$filename}";
        exec($command);
        $this->echoLog("tar backup_mysql:".$command);
    }
} 