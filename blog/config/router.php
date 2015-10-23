<?php
return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'enableStrictParsing' => false,
    'rules' => [
        [
            'pattern' => '/<controller:\w+>/<id:\d+>',
            'route' =>  '<controller>/info',
            'suffix'=>'.html'
        ],
        [
            'pattern' => '/<module:(wap)>/<controller:\w+>/<id:\d+>',
            'route' =>  '/<module>/<controller>/info',
            'suffix'=>'.html'
        ],
        '/<module:(wap)>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
        '/<module:(wap)>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
        '/<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
        '/<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        '/' => 'default/index',
        '/<id:\d+>' => 'default/info',
    ],
];