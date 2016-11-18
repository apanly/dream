#!/bin/sh
cmd='php /data/www/dream/yii release/index'
while true
do
    if [ $(ps -ef |grep  '$cmd' |grep -v grep|wc -l) -eq 0 ];then
        eval $cmd
        sleep 20;
    else
        echo 'queue is Running';
    fi
done
