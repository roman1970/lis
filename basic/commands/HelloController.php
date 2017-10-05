<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\DeutschItem;
use yii\base\ErrorException;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    public static $array;
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world')
    {
        self::$array = self::arrayFillRealNumberGeneratorWithDoubleValue(1, 33);
        echo $message . "\n";
    }

    /**
     * Тестовое задание.
     * Есть набор натуральных чисел, отсортированный в порядке возрастания. 
     * В него входят все числа из интервала [1, 2 ^ 32 - 1]. 
     * Каждое, за исключением одного - ровно по 1 разу. Одно дублируется. 
     * Реализовать на PHP 5.6+ самую быструю из возможных функцию поиска этого числа, 
     * которая принимает в качестве аргумента массив и возвращает дубликат 
     * (в stdout ничего выводить не нужно).
     * @param $arr
     * @return integer
     */

    public function actionFindDouble($dbl, $arr=[]){

        if(empty($arr)) $arr = self::arrayFillRealNumberGeneratorWithDoubleValue(1, 33, $dbl);
        
        for($i=1; $i< count($arr)-1; $i++){
            if($arr[$i] <= $arr[$i-1])  {
                echo $arr[$i-1].PHP_EOL; exit;
            }
            elseif ($arr[$i] <= $arr[$i-1] && $arr[$i] <= $arr[$i+1] ) {
                echo $arr[$i].PHP_EOL;
               // var_dump($arr);
                exit;
            }

            
            //else echo $arr[$i].PHP_EOL;
        }

        return var_dump($arr);
        
    }

    public static function realNumbersGenerator($start, $end)
    {
        if ($start < $end) {
            for ($i = $start; $i <= $end; $i++) {
                yield $i;
            }
        } else throw new \LogicException('Первое значение должно быть больше второго');

    }

    public function arrayFillRealNumberGeneratorWithDoubleValue($start, $end, int $dbl){
        $arr = [];
        if($dbl <= $start && $dbl >= $end) 
            $arr_dubl[rand($start, $end)] = rand($start, $end);
        else $arr_dubl[rand($start, $end)] = $dbl;

        foreach (self::realNumbersGenerator($start, $end) as $val){
            $arr[] = $val;
        }

        //$original = array( 'a', 'b', 'c', 'd', 'e' );
        //$inserted = array( 'x' ); // Not necessarily an array

        //array_splice( $original, 3, 0, $inserted ); // splice in at position 3
        // $original is now a b c x d e

        array_splice( $arr, rand($start, $end), 0, $arr_dubl );
        
        return $arr;
    }



    public function actionIsPalindrome($word)
    {
        $word = strtolower($word);
        $str_length = strlen($word);


        for($i=0,$j=($str_length-1); ($i<=floor($str_length/2) || $j>=floor($str_length/2)); $i++, $j--){
            echo $word[$i].'-';
            echo $word[$j].PHP_EOL;
            if (!($word[$i] == $word[$j])) {echo 'false'.PHP_EOL; return;}
        }
        echo 'true'.PHP_EOL;


    }

    /*
     * Write a function that provides change directory (cd) function for an abstract file system.

    Notes:
    
    Root path is '/'.
    Path separator is '/'.
    Parent directory is addressable as '..'.
    Directory names consist only of English alphabet letters (A-Z and a-z).
    The function will not be passed any invalid paths.
    Do not use built-in path-related functions.
    For example:
    
    $path = new Path('/a/b/c/d');
    $path->cd('../x')
    echo $path->currentPath;
    should display '/a/b/c/x'.
     */
    public function actionCd($newPath){
        $path = '/a/b/c/d';
        $arr_current_path = explode('/', $path );
        $arr_new_path = explode('/', $newPath);

        if($arr_new_path[0] == '') array_shift($arr_new_path);
        if($arr_current_path[0] == '') array_shift($arr_current_path);
        
        foreach ($arr_new_path as $new_dir){
           // echo $new_dir.PHP_EOL;
            if($new_dir == '..')  {
                array_pop($arr_current_path);
                array_shift($arr_new_path);
            }
        }
        
        //var_dump(array_merge($arr_current_path,$arr_new_path));
        
        var_dump(implode('/', array_merge($arr_current_path,$arr_new_path)));

    }

    /**
     * Генерим аудио немецких слов
     */
    public function actionEspeack(){
        
        $words = DeutschItem::find()->all();
        
        foreach ($words as $word) {
            $word_for_file = str_replace(' ', '_', $word->d_word);
            $word_for_file = str_replace('?', '', $word_for_file);
            $cmd = "espeak -v mb-de4 '".$word->d_word."' -s 100 -w /home/romanych/Музыка/Thoughts_and_klassik/deutsch/".$word_for_file.".wav";
            echo $cmd.PHP_EOL;
            shell_exec($cmd);
            $word->audio_link = "deutsch/".$word_for_file.".wav";
            $word->update(false);
        }
        
    }

    /**
     * Генерим аудио немецких фраз
     */
    public function actionEspeackPhrase(){

        $words = DeutschItem::find()->all();

        foreach ($words as $word) {
            $word_for_file = str_replace(' ', '_', $word->d_phrase);
            $word_for_file = str_replace('?', '', $word_for_file);
            $word_for_file = str_replace('.', '', $word_for_file);
            $cmd = "espeak -v mb-de4 '".$word->d_phrase."' -s 100 -w /home/romanych/Музыка/Thoughts_and_klassik/deutsch/".$word_for_file.".wav";
            echo $cmd.PHP_EOL;
            shell_exec($cmd);
            $word->audio_phrase_link = "deutsch/".$word_for_file.".wav";
            $word->update(false);
        }

    }

}
