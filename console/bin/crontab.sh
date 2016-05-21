#!/bin/bash
export YIIC="/home/www/yii_tools/dream/yii"

cmd=$1
mod=$2
cmd_params=("$@")

extra_params=""
for((i=0;i<$#;i++))
do
    if [ $i -gt 1 ]
    then
        extra_params=$extra_params" "${cmd_params[i]}
    fi
done

for((i=0;i<$mod;i++))
do
    current_full_cmd=" cd /tmp/ && nohup  php $YIIC $cmd $i $mod $extra_params &"
    echo ${current_full_cmd}
    eval $current_full_cmd
done