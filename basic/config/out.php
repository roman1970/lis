<?php
$params = require(__DIR__ . '/params.php');


if (isset($_GET['mode'])) {
  $mode = $_GET['mode']; 
}
else $mode = 'user';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => '/'.$mode.'/default/index',
    'modules' => [
        'user' => [
            'class'    => 'app\modules\user\Module',
            'controllerMap' => [
                'admin' => [
                    'class'  => 'app\controllers\user\AdminController',
                    //'layout' => 'app\views',
                ],
                'security' => 'app\controllers\user\SecurityController'
            ],
            'viewPath' => '@app/modules/user/views',
            'admins'   => ['roman'],
        ],
        'weather' => [
            'class' => 'app\modules\weather\Weather',
        ],
        'bardzilla' => [
            'class' => 'app\modules\bardzilla\Bardzilla',
        ],
        'russia2018' => [
            'class' => 'app\modules\russia2018\Russia2018',
        ],
        'knoledges' => [
            'class' => 'app\modules\knoledges\Knoledges',
        ],
        'markself' => [
            'class' => 'app\modules\markself\Markself',
        ],
        'prognose' => [
            'class' => 'app\modules\prognose\Prognose',
        ],
        'krokodile' => [
            'class' => 'app\modules\krokodile\Krokodile',
        ],
        'magazin' => [
            'class' => 'app\modules\magazin\Magazin',
        ],
        'rockncontroll' => [
            'class' => 'app\modules\rockncontroll\Module',
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
            'loginUrl' => ['/user/security/login'],
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'cart' => [
            'class' => 'app\components\ShoppingCart'
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
         * 'view' => [
            'theme' => [
                'basePath' => '@app/themes/landberry',
                //'baseUrl' => '@web/themes/landberry',
            ],
        ],
        */
        'view' => [
            'theme' => [
                'basePath' => '@app/themes/'.$mode,
                'baseUrl' => '@web/themes/'.$mode,
                'pathMap' => [
                    '@app/views' => '@app/themes/'.$mode

                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp-20.1gb.ru',
                'username' => 'u424229',
                'password' => '280699b4gh',
                'port' => '25',
                'encryption' => 'tls',
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
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => ['user'],
            //'defaultRoles' => ['user','moder','admin'],

            //зададим куда будут сохраняться наши файлы конфигураций RBAC
            'itemFile' => 'components/rbac/items.php',
            'assignmentFile' => 'components/rbac/assignments.php',
            'ruleFile' => 'components/rbac/rules.php'
        ],
        'db' => require(__DIR__ . '/db.php'),

        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<id:\d+>'   => '<controller>/view',
                '<module:\w+>/<controller:\w+>/<id:\d+>'   => '<module>/<controller>/view',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id>' => '<module>/<controller>/<action>/',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id>/<page>' => '<module>/<controller>/<action>/',
                '<controller:\w+>/<action:\w+>'   => '<controller>/<action>',


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
//print_r($config); exit;
return $config;
