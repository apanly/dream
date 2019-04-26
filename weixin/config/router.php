<?php
return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'enableStrictParsing' => false,
    'rules' => [
		[
			'pattern' => '/<controller:\w+>/<id:\w+>',
			'route'   => '<controller>/info',
			'suffix'  => '.html'
		],
        '/<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
        '/<controller:\w+>/<action:\w+>' => '<controller>/<action>',
		'/' => "default/index"
    ],
];