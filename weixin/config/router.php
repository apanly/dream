<?php
return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'enableStrictParsing' => false,
    'rules' => [
        '/<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
        '/<controller:\w+>/<action:\w+>' => '<controller>/<action>',
		'/' => "default/index"
    ],
];