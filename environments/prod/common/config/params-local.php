<?php
return [
    "curl" => [
        "timeout" => 5
    ],
    "domains" => [
        "blog" => "http://www.dr.local.com",
        "admin" => "http://admin.dr.local.com",
        "static" => "http://static.dr.local.com",
        "cdn_static" => "http://cdn.static.yunetidc.com",
        "pic1" => "http://pic1.vincentguo.cn",
        "cdn_pic1" => "http://cdn.pic1.yunetidc.com",
        "pic2" => "http://cdn.pic2.yunetidc.com",
        "cdn_pic2" => "http://cdn.pic2.yunetidc.com",
        "cdn_pic2_https" => "https://oeil0b8s3.qnssl.com",
        "pic3" => "http://pic3.vincentguo.cn",
        "cdn_pic3" => "http://cdn.pic3.yunetidc.com",
        "m"  => "http://m.vincentguo.cn",
        "cookie" => ".vincentguo.cn",
    ],
    "author" => [
        "nickname" => "编程浪子",
        "link" => "/default/about"
    ],
    'weixin' => [
        'mystarzone' => [
            'appid' => 'wx1b2fea3cb08d02ee',
            'appsecret' => 'xxx',
            'apptoken' => 'xxx'
        ],
        'imguowei_888' => [
            'appid' => 'wx936957aebefb4e76',
            'appsecret' => 'xxx',
            'apptoken' => 'xxx'
        ],
        'oauth' => [
            'appid' => 'xxx',
            'appsecret' => 'xxx',
            'apptoken' => 'xxx'
        ]
    ],
    'upload' => [
        "pic1" => "/data/www/pic1/",
        "pic2" => "/data/www/pic2/",
        "pic3" => "/data/www/pic3/",
        'qiniu_config' => [
            'ak' => 'xxx',
            'sk' => 'xxx'
        ]
    ],
    'switch' => [
        "cdn" => [
            "static" => false,
            "pic1" => false,
            "pic2" => false,
            "pic3" => false
        ]
    ],
    'report' => [
        'dir_path' => '/tmp/report/'
    ]
];
