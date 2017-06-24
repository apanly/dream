#!/bin/sh
export YIIC="/data/www/dream/yii"
cmd=$1
while true
do
    if [ $(ps -ef |grep  "/usr/bin/php $YIIC $cmd" |grep -v grep|wc -l) -eq 0 ];then
        current_full_cmd=" cd /tmp/  && nohup /usr/bin/php $YIIC $cmd &"
        echo ${current_full_cmd}
        eval $current_full_cmd
    else
        echo 'queue is Running';
    fi
    sleep 10;
done