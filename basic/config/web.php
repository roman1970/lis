<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'controllerMap' => [
                'admin' => [
                    'class'  => 'app\controllers\user\AdminController',
                    'layout' => 'path-to-your-admin-layout',
                ],
            ],
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '7haKvarJ7EWfIVOQeT6CaP_Am-8B1ZmL',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            //'class' => 'dektrium\user\Module',
            //'enableUnconfirmedLogin' => true,
            //'confirmWithin' => 21600,
           // 'cost' => 12,
            //'admins' => ['admin']
            //'class' => 'dektrium\user\Module',
            //'enableFlashMessages' => true,
           // 'enableAutoLogin' => true,
            'loginUrl' => ['/user/security/login'],
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),

        /*'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<id:\d+>'   => '<controller>/view',
                '<module:\w+>/<controller:\w+>/<id:\d+>'   => '<module>/<controller>/view',
                '<controller:\w+>/<action:\w+>'   => '<controller>/<action>',


            ],

        ],*/

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
