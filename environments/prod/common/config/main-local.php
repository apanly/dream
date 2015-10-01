<?php
return [
    'components' => [
        'blog' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=dream_blog',
            'username' => 'xxx',
            'password' => 'xxx',
            'charset' => 'utf8',
        ],
        'cache' => [
            'class' => 'common\components\RedisCache',
            'keyPrefix' => 'REDIS_CACHE_RRR_',
            'redis' => [
                'database' => 0,
                'host' => 'localhost',
                'port' => 6379,
            ]
        ]
    ],
];