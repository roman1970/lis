<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

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
	'authManager' => [
	    'class' => 'yii\rbac\PhpManager',
	    'defaultRoles' => ['user','moder','admin'], //здесь прописываем роли
	    //зададим куда будут сохраняться наши файлы конфигураций RBAC
	    'itemFile' => 'components/rbac/items.php',
	    'assignmentFile' => 'components/rbac/assignments.php',
	    'ruleFile' => 'components/rbac/rules.php'
	],
        'db' => $db,
    ],
    'params' => $params,
];
