<?php
//phpinfo(); exit;
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

//$r = file_get_contents('http://soccer.qplis.ru/txt.php');  echo $r; exit;
//$loggss = fopen("logss.txt", "w");
//fwrite($loggss, time().PHP_EOL);
//fwrite($loggss, implode(PHP_EOL, $_SERVER));
//fclose($loggss);

if(isset($_GET['siteParamIdForTheme'])) {
    $config = require(__DIR__ . '/../config/out.php');
}
else {
    // comment out the following two lines when deployed to production
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');

    $config = require(__DIR__ . '/../config/web.php');
}

(new yii\web\Application($config))->run();
