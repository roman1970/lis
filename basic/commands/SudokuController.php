<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;


use yii\console\Controller;
use Yii;


class SudokuController extends Controller
{

    public function actionIndex()
    {
        $methods = get_class_methods($this);
        echo 'Actions:' . "\r\n";
        foreach ($methods as $method)
            if (preg_match('/^action(.+)$/', $method, $match))
                echo ' - ' . $match[1] . "\r\n";
    }

    public function actionFillField($input){
        $arr = [];
        $j = 0;
        //рисуем и заполняем массив
        for($i = 0; $i <= 80; $i++){

            $arr[$i % 9][$j] = $input[$i];
            if($i % 9 == 0) {
                $j++;
                echo "\r\n";
            }

            echo $input[$i] . " | ";

        }
        echo "\r\n";
        //print_r($arr);

        for($i=0; $i <= 8; $i++){
            for($m=1; $m < 9; $m++){
                if($arr[$i][$m] == '1') {
                    echo "В столбец ". $i . " в строку " . $m . " единицу ставить нельзя";
                }
            }
        }

        for($i=0; $i < 9; $i += 3){
            for($m=1; $m <= 3; $m++){
                if($arr[$i][$m] == '1') {
                    echo "В столбец ". $i . " в строку " . $m . " единицу ставить нельзя";
                }
            }
        }


    }
}