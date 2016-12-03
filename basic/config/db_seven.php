<?php


return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.$params['db_host'].';dbname='.$params['db_name_log'],
    'username' => $params['db_username_log'],
    'password' => $params['db_password_log'],
    'charset' => 'utf8',
];
