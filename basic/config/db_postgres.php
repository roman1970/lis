<?php
return [
    'class' => 'yii\db\Connection',
    //'dsn' => 'mysql:host=localhost;dbname=plis',
    'dsn' => 'pgsql:host=localhost;port=5432;dbname=postgres',
    //sudo apt-get install php7.0-pgsql - не забудем поставить драйвер
    //'username' => 'root',
    'username' => 'postgres',
    //'password' => 'vbifcdtnf',
    'password' => 'rhjfnjxdbkb',
    'charset' => 'utf8',
];
