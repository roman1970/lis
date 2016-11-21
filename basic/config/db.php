<?php

if(!isset($dbName))
{
    switch (__DIR__)
    {
        case '/home/romanych/public_html/plis/basic/config':
            $dbName = $params['db_name'];
            $dbUser = $params['db_username'];
            $dbPassword = $params['db_password'];
            $dbHost = $params['db_host'];
            break;
        /*
         *  'dsn' => 'mysql:host='.$params['db_host'].';dbname='.$params['db_name'],
    'username' => $params['db_username'],
    'password' => $params['db_password'],

        case '/home/romanych/public_html/plis/basic/config':
            $dbName = '';
            $dbUser = '';
            $dbPassword = '';
            $dbHost = '127.0.0.1';
            break;


return [
    //'log_file' =>  '/var/log/nginx/access.log',
    'email_host' => 'smtp-20.1gb.ru',
    'cookieValidationKey' => '7haKvarJ7EWfIVOQeT6CaP_Am-8B1ZmL',
    'mail_username' => 'u424229',
    'mail_password' => '280699b4gh',
    'api_key' => 'e44',
    'db_host' => 'localhost',
    'db_name' => 'plis',
    'db_username' => 'root',
    'db_password' => 'vbifcdtnf'
];
        */

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
    'dsn' => 'mysql:host='.$params['db_host'].';dbname='.$params['db_name'],
    'username' => $params['db_username'],
    'password' => $params['db_password'],
    'charset' => 'utf8',
];
