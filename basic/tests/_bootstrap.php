<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

defined('YII_APP_BASE_PATH') or define('YII_APP_BASE_PATH', dirname(__DIR__));

require(YII_APP_BASE_PATH . '/vendor/autoload.php');
require(YII_APP_BASE_PATH . '/vendor/yiisoft/yii2/Yii.php');

Yii::setAlias('@tests', dirname(__DIR__));

$config = \yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../config/web.php'),
    require(__DIR__ . '/../config/tests.php')
);

//(new yii\web\Application($config))->run();

new \yii\web\Application($config);

