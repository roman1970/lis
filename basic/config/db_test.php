<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.$params['db_host'].';dbname='.$params['db_name_test'],
    'username' => $params['db_username_test'],
    'password' => $params['db_password_test'],
    'charset' => 'utf8',
];
