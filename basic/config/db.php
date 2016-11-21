<?php


return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.$params['db_host'].';dbname='.$params['db_name'],
    'username' => $params['db_username'],
    'password' => $params['db_password'],
    'charset' => 'utf8',
];
