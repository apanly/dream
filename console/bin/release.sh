#!/bin/sh
while true
do
    if [ $(ps -ef |grep  '/data/htdocs/tools/yii release/index' |grep -v grep|wc -l) -eq 0 ];then
        /usr/bin/php /data/htdocs/tools/yii release/index
        sleep 3;
    else
        echo 'queue is Running';
    fi
done
