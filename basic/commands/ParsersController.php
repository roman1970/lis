<?php
namespace app\commands;


use app\models\Currencies;
use app\models\CurrHistory;
use yii\console\Controller;
use yii\helpers\Url;
use Yii;
use app\components\Helper;
use app\components\TranslateHelper;


class ParsersController extends Controller
{
    public $arr = [];
    public static $str = '';

    public function actionIndex()
    {
        $methods = get_class_methods($this);
        echo 'Actions:' . "\r\n";
        foreach ($methods as $method)
            if (preg_match('/^action(.+)$/', $method, $match))
                echo ' - ' . $match[1] . "\r\n";
    }


    public function actionSoccerstand(){

        $ch = curl_init();
        $url = "http://www.soccerstand.com/ru/match/S2vkOWlT/#player-statistics;0";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.95 Safari/537.11');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
        curl_setopt ($ch, CURLOPT_COOKIE, session_name() . '=' . session_id());
        $result = curl_exec($ch);
        curl_close($ch);

        print_r($result);

        $fp = fopen("soccertest.txt", "a"); // Открываем файл в режиме записи
        $test = fwrite($fp, $result); // Запись в файл
        if ($test) echo 'Данные в файл успешно занесены.';
        else echo 'Ошибка при записи в файл.';
        fclose($fp); //Закрытие файла


    }

    /**
     * Спорт-Экспресс парсер
     */
    public function  actionSeParser(){

        //Error_Reporting(E_ALL & ~E_NOTICE);
        header('Content-Type: text/html; charset=utf-8');
        $head = file_get_contents(Url::to("@app/commands/header.html"));
        $year = 2016;
        $m = date("m");
        $d = date("d");
        $date = "$year-$m-$d";
        $url = "http://www.sport-express.ru/newspaper/$date/";
        $content = file_get_contents($url);
        if ($pos = strpos($content, 'Номер за это число не выходил'))
                   {
                       $handle = fopen("/home/romanych/se/$year/SE$date-nevyh.txt", "a");
                       fwrite($handle, 'Номер за это '. $date .' число не выходил');
                       fclose($handle);
                       die();
                   }
            $handle = fopen("/home/romanych/se/$year/se$date.html", "a");
            fwrite($handle, $head);

            for ($j = 1; $j <= 16; $j++) {

                for ($i = 1; $i <= 10; $i++) {

                    $url = "http://www.sport-express.ru/newspaper/$date/$j" . "_$i/?view=page";

                    try {
                        $content = file_get_contents($url);
                    } catch (\ErrorException $e) {
                        continue;
                    }

                    $tag_in = '<div class="art_item">';
                    //$tag_in2 = '<b><font color="white">ФУТБОЛ</font></b>';
                    $tag_out = '<div class="se2_paginator">';



                    //отрезка нужного куска сайта
                    $position = strpos($content, $tag_in);
                    /*
                    if (!$position)
                        $position = strpos($content, $tag_in2);
                    if (!$position)
                        continue;
                    */
                    $content = substr($content, $position);
                    $position = strpos($content, $tag_out);
                    $content = substr($content, 0, $position);
                    /*

                    $content = str_replace('</p>', '  ', $content);
                    $content = str_replace('</a>', '  ', $content);
                    $content = str_replace('</td>', '  ', $content);
                    $content = str_replace('</a>', '  ', $content);
                    $content = str_replace('<br />', '  ', $content);
                    $content = str_replace('<br />', '  ', $content);
                    $content = str_replace('</b>', '  ', $content);
                    $content = strip_tags($content);
                    */


                    echo 'Страница '. $j .', '. 'Статья '. $i . PHP_EOL;
                    $content = iconv("windows-1251", "UTF-8", $content);

                    fwrite($handle, $content);

                }
            }
            fclose($handle);
            if (filesize("/home/romanych/se/$year/se$date.html") == 0)
                unlink("/home/romanych/se/$year/se$date.html");

        echo 'Генерим дерево'. PHP_EOL;
        //генерим страницу с файловым деревом
        $f_tree = fopen("/home/romanych/se/ftree.html", "w");
        $this->directory_tree("/home/romanych/se", "2016/");
        fwrite($f_tree, self::$str);
        fclose($f_tree);



    }

    public function actionCurrencyTest()
    {
        for($i=0; $i<45; $i++) {
                echo $i;

            $data_slash = Helper::getDateIntervalYesterdayInDashOrSlashFormat(new \DateTime(), $i, 'slash');
            $data_dash = Helper::getDateIntervalYesterdayInDashOrSlashFormat(new \DateTime(), $i, 'dash');

            $url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req='.$data_slash;
            //var_dump($url);

            $xml_contents = file_get_contents($url);
            if ($xml_contents === false)
                throw new \ErrorException('Error loading ' . $url);

            $xml = new \SimpleXMLElement($xml_contents);

            //$date = $xml->attributes()->Date;

            foreach ($xml as $node) {
                $current_curr = new CurrHistory();
                if(Currencies::findOne(['valute_id' => $node->attributes()->ID]))
                    $current_curr->currency_id = Currencies::findOne(['valute_id' => $node->attributes()->ID])->id;
                else {
                    $new_currency = new Currencies();
                    $new_currency->name = TranslateHelper::translit($node->Name);
                    $new_currency->valute_id = $node->attributes()->ID;
                    $new_currency->char_code = $node->CharCode;
                    $new_currency->num_code = $node->NumCode;
                    $new_currency->save(false);
                    $current_curr->currency_id = $new_currency->id;
                    //var_dump($new_currency); exit;
                }

                $current_curr->date = $data_dash;
                $current_curr->nominal = $node->Nominal;
                $current_curr->value = str_replace(',', '.', $node->Value);
                //замена запятой на точку позволят использовать
                //формат с плавоющей точкой

                $current_curr->save(false);
                //echo $current_curr->value; exit;

            }


        }


    }

    public function actionMusicDirGenerator(){
        echo 'Генерим дерево'. PHP_EOL;
        //генерим страницу с файловым деревом
        $f_tree = fopen("/home/romanych/www/vrs/music.html", "w");
        self::$str = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        $this->directory_tree("/home/romanych/music/Music", "music/");
        fwrite($f_tree, self::$str);
        fclose($f_tree);
    }

    /**
     * Кэшит дерево директории
     * @param string $dir
     * @return string
     */

    public static function directory_tree($dir) {
        //$add = $addDir;
        $list = scandir($dir);
        //var_dump($list); exit;


        if (is_array($list)) {
            self::$str .= '<ul>';
            $list = array_diff($list, array('.', '..'));
            if ($list) {
                $i = 0;

                foreach ($list as $name) {
                    $i++;
                    echo $i . PHP_EOL;
                    //if ($i > 5) break;
                    $path = $dir . '/' . $name;
                    //var_dump($path);
                    $is_dir = is_dir($path);
                    self::$str .= '<li>';
                    /*
                    $ref = str_replace('/home/romanych','',$path);

                    if($name != 'ftree.html') {

                        self::$str .= '<a href="'.$ref.'">'. htmlspecialchars($name). '</a>';
                    }
                    */
                    if($name != 'ftree.html') {
                        self::$str .= '<a href="2016/'.$name.'">'. htmlspecialchars($name). '</a>';
                    }


                    if ($is_dir)
                        self::directory_tree($path);
                    //var_dump(self::$str);

                    self::$str .= '</li>';
                }
                self::$str .= '</ul>';
            }
        }
        else {
            self::$str .= '<i>не могу прочитать</i>';
        }

    }
}