<?php

namespace common\service;


class Constant {

    public static $posts_type = [
        1 => "日志",
        2 => "图片",
        3 => "视频",
        4 => "音频"
    ];

    public static $status_desc = [
        0 => ['class' => 'danger','desc' => "隐藏"],
        1 => ['class' => 'success','desc' => "正常"]
    ];

    public static $original_desc = [
        0 => ['class' => 'danger','desc' => "非原创"],
        1 => ['class' => 'success','desc' => "原创"]
    ];
} 