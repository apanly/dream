<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    "timezone"  =>  "Asia/Shanghai",
    'modules' => [
        'weixin'=>[
            'class' =>'api\modules\weixin\WeixinModule'
        ],
        'emoticon'=>[
            'class' =>'api\modules\emoticon\EmoticonModule'
        ],
		'mina' => [
			'class' => 'api\modules\mina\MinaModule',
		]
    ],
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning','trace'],
                ],
            ],
        ],
        "urlManager" => require (__DIR__ . '/router.php'),
        'errorHandler' => [
            'errorAction' => 'error/error',
        ],
    ],
    'params' => $params,
];
