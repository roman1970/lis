<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Matches;
use yii\console\Controller;
use app\components\DocxConverter;
use app\models\Country;
use app\models\Articles;
use Yii;
use yii\helpers\Url;


class KhlController extends Controller
{


    public function actionIndex()
    {
        $methods = get_class_methods($this);
        echo 'Actions:' . "\r\n";
        foreach ($methods as $method)
            if (preg_match('/^action(.+)$/', $method, $match))
                echo ' - ' . $match[1] . "\r\n";
    }

    public function actionFillTeams()
    {

    }

}