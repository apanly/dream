<?php
return [
    'components' => [
        'blog' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=dream_blog',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ]
    ],
];
