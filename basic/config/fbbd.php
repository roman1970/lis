<?php

if(!isset($dbName))
{
    switch (__DIR__)
    {
        case '/home/romanych/public_html/plis/basic/config':
            $dbName = 'ffbase';
            $dbUser = 'root';
            $dbPassword = 'vbifcdtnf';
            $dbHost = 'localhost';
            break;

        case '/home/virtwww/w_qplis-ru_c772050d/http/lis/basic/config':
            $dbName = 'gb_x_qplis';
            $dbUser = 'gb_x_qplis';
            $dbPassword = '9z49c9ezgh';
            $dbHost = 'mysql92.1gb.ru';
            break;


        default:
            $dbName = '';
            $dbUser = '';
            $dbPassword = '';
            $dbHost = '';
            break;
    }
}

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.$dbHost.';dbname='.$dbName,
    'username' => $dbUser,
    'password' => $dbPassword,
    'charset' => 'utf8',
];
