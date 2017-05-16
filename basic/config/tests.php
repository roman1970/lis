<?php
return [
    'language' => 'en-US',

    'components' => [
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=yii2_basic_tests',
           // 'dsn' => 'mysql:host=localhost;dbname=plis',
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];