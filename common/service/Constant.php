<?php

namespace common\service;


class Constant {

    public static $posts_type = [
        1 => "日志",
        2 => "图片",
        3 => "视频",
        4 => "音频"
    ];

	public static $soft_type = [
		1 => "小程序",
		2 => "MacApp",
		3 => "Web程序",
	];

	public static $soft_status_desc = [
		1 => [ 'class' => 'success','desc' => "正常" ],
		0 => [ 'class' => 'danger','desc' => "隐藏" ]
	];

    public static $status_desc = [
		1 => ['class' => 'success','desc' => "正常"],
        0 => ['class' => 'danger','desc' => "隐藏"],
        -1 => ['class' => 'orange','desc' => "正在写"],
        -2 => ['class' => 'gray','desc' => "排队中"],
    ];

    public static $original_desc = [
        0 => ['class' => 'danger','desc' => "非原创"],
        1 => ['class' => 'success','desc' => "原创"]
    ];

    public static $hot_desc = [
        0 => ['class' => 'danger','desc' => "非热门"],
        1 => ['class' => 'success','desc' => "热门"]
    ];

    public static $read_desc = [
        -2 => ['class' => 'info','desc' => "计划读"],
        -1 => ['class' => 'info','desc' => "在读中"],
        0 => ['class' => 'danger','desc' => "未读"],
        1 => ['class' => 'success','desc' => "已读完"]
    ];

	public static $uuid_cookie_name = "vuuid";

	public static $low_password = [
		"000000","111111","11111111","112233","123123","123321","123456","12345678","654321","666666","888888","abcdef","abcabc","abc123","a1b2c3","aaa111","123qwe","qwerty","qweasd","admin","password","p@ssword","passwd","iloveyou","5201314"
	];

	public static $default_avatar = 'no_avatar';
	public static $default_password = '******';
	public static $default_time_stamps = '0000-00-00 00:00:00';
	public static $default_syserror = '系统繁忙，请稍后再试~~';

} 