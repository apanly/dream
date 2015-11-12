<?php
return [
    "curl" => [
        "timeout" => 30
    ],
    "domains" => [
        "blog" => "http://blog.dr.local.com",
        "admin" => "http://admin.dr.local.com",
        "static" => "http://static.dr.local.com",
        "cdn_static" => "http://static.dr.local.com",
        "pic1" => "http://pic1.dr.local.com",
        "cdn_pic1" => "http://pic1.dr.local.com",
        "m" => "http://m.dr.local.com"
    ],
    "author" => [
        "nickname" => "郭大帅哥",
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
            'appid' => 'xxxx',
            'appsecret' => 'xx',
            'apptoken' => 'xx'
        ]
    ],
    'upload' => [
        "pic1" => "/data/www/pic1/"
    ],
    'switch' => [
        "cdn" => [
            "static" => false,
            "pic1" => false,
            "pic2" => false
        ]
    ]
];