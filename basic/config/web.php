<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    //'defaultRoute' => '/weather/default/index',
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['192.168.1.33']
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
            'controllerMap' => [
                'admin' => [
                    'class'  => 'app\controllers\user\AdminController',
                    //'layout' => 'app\views',
                ],
                'security' => 'app\controllers\user\SecurityController'
            ],
            'enableUnconfirmedLogin' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['roman']
        ],
        'rbac' => [
            'class' => 'dektrium\rbac\RbacWebModule',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'dektrium\rbac\controllers\AssignmentController',
                    'userClassName' => 'app\models\User',
                ]
            ]
        ],
        'weather' => [
            'class' => 'app\modules\weather\Weather',

        ],
        'diary' => [
            'class' => 'app\modules\diary\Diary',
        ],
        'khl' => [
            'class' => 'app\modules\khl\Khl',
            //'admins' => ['roman']
        ],
        'repertuar' => [
            'class' => 'app\modules\repertuar\Repertuar',
        ],
        'currency' => [
            'class' => 'app\modules\currency\Module',
        ],

    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => $params['cookieValidationKey']
            //'enableCsrfValidation' => false,
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->data !== null && !empty(Yii::$app->request->get('suppress_response_code'))) {
                    $response->data = [
                        'success' => $response->isSuccessful,
                        'data' => $response->data,
                    ];
                    $response->statusCode = 200;
                }
            },
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'translater' => [
            'class' => 'app\components\TranslateHelper'
        ],
        'sphinx' => [
            'class' => 'yii\sphinx\Connection',
            'dsn' => 'mysql:host=127.0.0.1;port=9306;charset=utf8',
            // Обязательно укажите порт, который Вы задали в конфигурационном файле sphinx, секция searchd параметр
            // listen
            'username' => '',
            'password' => '',
            ],

           // http://bar-data.com/blog/yii2/sphinx-and-yii2-integration-an-example-of-working-with-the-sphinx-on-yii2#hcq=Hdb7w0q
        /*
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/user/security/login'],
        ],
        */

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        /*
         * 'view' => [
            'theme' => [
                'basePath' => '@app/themes/landberry',
                //'baseUrl' => '@web/themes/landberry',
            ],
        ],
        */
        'view' => [
            'theme' => [

                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => $params['email_host'],
                'username' => $params['mail_username'],
                'password' => $params['mail_password'],
                'port' => '465',
                'encryption' => 'ssl',
                'messageConfig' => [
                    'charset' => 'UTF-8',
                ],

                    'streamOptions' => [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
               
                ],

            ],
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
        /*'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            //'defaultRoles' => ['user'],
            'defaultRoles' => ['user','moder','admin'],

            //зададим куда будут сохраняться наши файлы конфигураций RBAC
            'itemFile' => 'components/rbac/items.php',
            'assignmentFile' => 'components/rbac/assignments.php',
            'ruleFile' => 'components/rbac/rules.php'
        ],
        */
        'authManager' => [
                'class' => 'app\components\MyManager',
        ],

        'db' => require(__DIR__ . '/db.php'),
        'db_sevens' => require(__DIR__ . '/db_seven.php'),
        'db_test' => require(__DIR__ . '/db_test.php'),
        'db_postgres' => require(__DIR__ . '/db_postgres.php'),

        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
           // 'enableStrictParsing' => true,
            'rules' => [
                '<controller:\w+>/<id:\d+>'   => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'   => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<id:\d+>'   => '<module>/<controller>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                //'<controller:\w+>/<action:\w+>'   => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',

                '/plis' => '/',

                //'/show/<id:\d+>' => '/article-by-id'
               [
                   'class' => 'yii\rest\UrlRule',
                   'controller' => 'itemapi',
                   'tokens' => [
                       '{id}' => '<id:\\w+>'
                   ],
                   'pluralize' => false,
               ],

            ],

        ],

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
