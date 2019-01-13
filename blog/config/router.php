<?php
return [
    'enablePrettyUrl'  => true,
    'showScriptName' => false,
    'enableStrictParsing' => false,
    'rules'               => [
        [
            'pattern' => '/<controller:\w+>/<id:\w+>',
            'route'   => '<controller>/info',
            'suffix'  => '.html'
        ],
        [
            'pattern' => '/<module:(wap|market)>/<controller:\w+>/<id:\d+>',
            'route'   => '/<module>/<controller>/info',
            'suffix'  => '.html'
        ],
        '/<module:(wap|game|weixin|mate|demo|market)>/<controller:\w+>/<action:\w+>/<id:\d+>' =>'<module>/<controller>/<action>',
        '/<module:(wap|game|weixin|mate|demo|market)>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
        '/<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
        '/<controller:\w+>/<action:\w+>'  => '<controller>/<action>',
        '/'  => 'default/index',
        '/<id:\d+>' => 'default/info',
        '/wap' => '/wap/default/index',
        '/wap/<id:\d+>'  => '/wap/default/info',
    ],
];