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
        'dream_log' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=dream_log',
            'username' => 'xxx',
            'password' => 'xxx',
            'charset' => 'utf8',
        ]
    ],
];