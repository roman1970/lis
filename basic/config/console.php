<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');
Yii::setAlias('@webroot', dirname(__DIR__) . '/web/themes/russia2018');
Yii::setAlias('@russia_root', dirname(__DIR__) . '/web/themes/russia2018');
Yii::setAlias('@web', dirname(__DIR__) .'/');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
        'debug' => 'yii\debug\Module',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'sphinx' => [
            'class' => 'yii\sphinx\Connection',
            'dsn' => 'mysql:host=127.0.0.1;port=9306;charset=utf8',
            // Обязательно укажите порт, который Вы задали в конфигурационном файле sphinx, секция searchd параметр
            // listen
            'username' => '',
            'password' => '',
        ],
        /*
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => ['user','moder','admin'], //здесь прописываем роли
            //зададим куда будут сохраняться наши файлы конфигураций RBAC
            'itemFile' => 'components/rbac/items.php',
            'assignmentFile' => 'components/rbac/assignments.php',
            'ruleFile' => 'components/rbac/rules.php'
        ],
        */
        'authManager' => [
            'class' => 'app\components\MyManager',
        ],
        'db' => $db,
        'db_test' => require(__DIR__ . '/db_test.php'),
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => dirname(__DIR__),
            'hostInfo' => '',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<id:\d+>'   => '<controller>/view',
                '<module:\w+>/<controller:\w+>/<id:\d+>'   => '<module>/<controller>/view',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>/',
                '<controller:\w+>/<action:\w+>'   => '<controller>/<action>',


            ],

        ],
    ],
    'params' => $params,
];
