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
        '/<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
        '/<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        '/' => 'default/index',
        '/<id:\d+>' => 'default/info',
    ],
];