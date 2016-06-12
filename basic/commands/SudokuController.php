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
        $non_allowed = [];
        $kvadrat = 0;
        $j = 0;
        $sudoku = "";
        //рисуем и заполняем массив
        for($i = 0; $i <= 80; $i++){


            if($i % 9 == 0) {
                $j++;
                echo "\r\n";
                $sudoku .= "\r\n";
            }
            $arr[$i % 9][$j] = $input[$i];

            echo $input[$i] . " | ";
            $sudoku .= $input[$i] . " | ";

        }
        echo "\r\n";
        //print_r($arr);

        for($c=1; $c < 10; $c++){


            //проверяем строки и столбцы
            for($i=0; $i <= 8; $i++){
                for($m=1; $m < 9; $m++){
                    if($arr[$i][$m] == $c) {
                        echo "\r\n";
                        echo "В столбец ". $i . " в строку " . $m ." " . $c ."  ставить нельзя";
                        for($m=1; $m < 9; $m++) {
                            $non_allowed[$c][$i][$m] = 0;
                        }
                        break;
                    }

                }
            }
            //print_r($non_allowed);
            //echo $sudoku;
            //exit;

            //проверяем квадраты
            for($n=0; $n < 9; $n+=3) {

                for($i=0; $i < 3; $i++){
                    for($m=1; $m <= 3; $m++){
                        //print_r($arr);
                        if($arr[$i][$m+$n] == $c) {
                            $kvadrat = $n+1;
                            echo "\r\n";
                            echo "В квадрат ". $kvadrat ." " . $c ." ставить нельзя";
                            for($i=0; $i < 3; $i++){
                                for($m=1; $m <= 3; $m++) {
                                    $non_allowed[$c][$i][$m+$n] = 0;
                                }
                            }
                            //$non_allowed[$c]['q'][] = $kvadrat;
                            break;
                        }
                    }
                }

                for($i=3; $i < 6; $i++){
                    for($m=1; $m <= 3; $m++){
                        if($arr[$i][$m+$n] == $c) {
                            $kvadrat = $n+2;
                            echo "\r\n";
                            echo "В квадрат ". $kvadrat ." " . $c ." ставить нельзя";
                            for($i=3; $i < 6; $i++){
                                for($m=1; $m <= 3; $m++){
                                    $non_allowed[$c][$i][$m+$n] = 0;
                                }
                            }
                            //$non_allowed[$c]['q'][] = $kvadrat;
                            break;
                        }
                    }
                }

                for($i=6; $i < 9; $i++){
                    for($m=1; $m <= 3; $m++){
                        if($arr[$i][$m+$n] == $c) {
                            $kvadrat = $n+3;
                            echo "\r\n";
                            echo "В квадрат ". $kvadrat ." " . $c ." ставить нельзя";
                            for($i=6; $i < 9; $i++){
                                for($m=1; $m <= 3; $m++){
                                    $non_allowed[$c][$i][$m+$n] = 0;
                                }
                            }

                            //$non_allowed[$c]['q'][] = $kvadrat;
                            break;
                        }
                    }
                }
            }


        }
        print_r($non_allowed);
        echo $sudoku;


    }
}