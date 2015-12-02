<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;


use yii\console\Controller;
use Yii;


class RandController extends Controller
{

    public function actionIndex()
    {
        $methods = get_class_methods($this);
        echo 'Actions:' . "\r\n";
        foreach ($methods as $method)
            if (preg_match('/^action(.+)$/', $method, $match))
                echo ' - ' . $match[1] . "\r\n";
    }

    public function actionRandDataAnaPageForDiary(){

        echo date("Y-m-d", mt_rand(mktime(0,0,0,0,0,2009), time()))."\r\n";
    }

    public function actionRandDataAnaPageForDiaryPage($max){

        echo mt_rand(0,$max)."\r\n";
    }

}