<?php
return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'enableStrictParsing' => false,
    'rules' => [
        '/<module:(weixin)>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
        '/<module:(weixin)>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
        '/<controller:\w+>/<id:\d+>' => '<controller>/info',
        '/<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
        '/<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        '/' => 'default/index',
        '/<id:\d+>' => 'default/info',
    ],
];