<?php

namespace app\commands;

use app\models\City;
use app\models\Khlteams;
use app\models\Matches;
use yii\console\Controller;
use app\components\DocxConverter;
use app\models\Country;
use app\models\Articles;
use Yii;
use yii\helpers\Url;


class KhlController extends Controller
{

    public $arrOfTeams = [
        'Салават Юлаев' => 'Уфа',
        'Сибирь' => 'Новосибирск',
        'Динамо Мн' => 'Минск',
        'Динамо Р' => 'Рига',
        'Йокерит' => 'Хельсинки',
        'Медвешчак' => 'Загреб',
        'СКА' => 'Санкт-Петербург',
        'Слован' => 'Братислава',
        'Спартак' => 'Москва',
        'Витязь' => 'Москва',
        'Локомотив' => 'Ярославль',
        'Динамо М' => 'Москва',
        'Северсталь' => 'Череповец',
        'Торпедо' => 'Нижний Новгород',
        'ХК Сочи' => 'Сочи',
        'ЦСКА' => 'Москва',
        'Автомобилист' => 'Екатеринбург',
        'Ак Барс' => 'Казань',
        'Лада' => 'Тольятти',
        'Металлург Мг' => 'Магнитогорск',
        'Нефтехимик' => 'Нижнекамск',
        'Трактор' => 'Челябинск',
        'Югра' => 'Ханты-Мансийск',
        'Авангард' => 'Омск',
        'Адмираль' => 'Владивосток',
        'Амур' => 'Хабаровск',
        'Барыс' => 'Астана',
        'Металлург Нк' => 'Новокузнецк'

    ];

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
        foreach ($this->arrOfTeams as $team => $city) {

            $model = new Khlteams();
            $model->name = $team;

            $city_id = City::find()
                ->where("name like('" . $city . "')")
                ->one()->id;
            if(!$city_id) $city_id = 1513;


            $model->city_id = $city_id;
            $model->save(false);
        }
    }

    /**
     * Добавление новых матчей в КХЛ
     */
    public function actionAddNewMatches()
    {
        $arr_datas_classes = [
            'tname-home', //хозяин
            'tname-away', //гость
            'mstat-date', //дата
            'mstat', // статус матча, напр, после буллитов
            'current-result', // результат 2-2
            'subincident-penalty', // удаление

        ];

        $url = Url::to("@app/commands/khl.html");

        $content = file_get_contents($url);
        $tnamehome = "";
        $tnameguest = "";
        $date = "";
        $stat = "";
        $wrapper = [];
        $ud = "";

        //var_dump(mb_detect_encoding($content, array('UTF-8', 'Windows-1251'), true)); exit;

        //$content = iconv(mb_detect_encoding($content, array('UTF-8', 'Windows-1251'), true), 'Windows-1251', $content);

        $content = str_replace(chr(9), '', $content);
        $content = str_replace(chr(11), '', $content);  // заменяем табуляцию на пробел
        $content = str_replace(chr(13), '', $content);
        $content = str_replace(chr(10), '', $content);

        $chars = preg_split('/div id=\"detcon\"/', $content, -1, PREG_SPLIT_NO_EMPTY); //разделяем контент на матчи
        $j = count($chars);

        for ($m = 0; $m < $j; $m++) {
            $dom = new \DomDocument();
            libxml_use_internal_errors(true);
            $head = file_get_contents(Url::to("@app/commands/header.html"));
            $match = $head . $chars[$m]; //добавляем хэдер

            $dom->loadHTML($match);


            $td = $dom->getElementsByTagName("td");
            foreach ($td as $node) {

                if ($node->getAttribute('class') == "tname-home logo-enable") {

                    $tnamehome = self::clearString(trim($node->textContent));

                    }
                if ($node->getAttribute('class') == "tname-away logo-enable") {

                    $tnameguest = self::clearString(trim($node->textContent));

                }

                if ($node->getAttribute('class') == "mstat-date") {

                    $date = $node->textContent;

                }

                if ($node->getAttribute('class') == "mstat") {

                    $stat = self::clearString(trim($node->textContent));

                }

            }

            $div = $dom->getElementsByTagName("div");
            foreach ($div as $node) {

                if ($node->getAttribute('class') == "time-box-wide") {

                    $wrapper[]['time'] = $node->textContent;

                }
            }

            $td = $dom->getElementsByTagName("td");

            foreach ($td as $node) {

                if ($node->getAttribute('class') === 'summary-vertical fr') {
                        $dt = $node->nodeValue;
                        $dom_in = new \DomDocument();
                        $html = $node->ownerDocument->saveHTML($node);
                        $newhtml = $head . $html;
                        $dom_in->loadHTML($newhtml);


                        $dv = $dom_in->getElementsByTagName("div");


                        foreach ($dv as $node) {

                            if ($node->getAttribute('class') === 'wrapper') {
                                var_dump($node);

                                $ud .= $node->textContent. ", ";

                            }

                        }

                    }
                }

                    if($tnamehome) echo "хозяин - ".$tnamehome. "\n\r";
            if($tnameguest) echo "гость - ".$tnameguest. "\n\r";
            if($date) echo "дата-время - ".$date. "\n\r";
            if($stat) echo "статус - ".$stat. "\n\r";
            if($ud) echo "уд - ". $ud. "\n\r";
            //var_dump($wrapper);
        }
    }

    public static function unichr($dec) {
        if ($dec < 128) {
            $utf = chr($dec);
        } else if ($dec < 2048) {
            $utf = chr(192 + (($dec - ($dec % 64)) / 64));
            $utf .= chr(128 + ($dec % 64));
        } else {
            $utf = chr(224 + (($dec - ($dec % 4096)) / 4096));
            $utf .= chr(128 + ((($dec % 4096) - ($dec % 64)) / 64));
            $utf .= chr(128 + ($dec % 64));
        }
        return $utf;
    }

    public static function replace_unicode_escape_sequence($match) {
        return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
    }

    public static function unicode_chr($chr) {
        $x = explode("+", $chr);
        $str = "\u".end($x);
        return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'self::replace_unicode_escape_sequence', $str);
    }

    public static function clearString($string){
        return  preg_replace("/[^СДМЮЙВЛТХКАБНПабвгдеёжзийклмнопрстуфхчцшщъыьэюя\s]+/", "", $string);
    }



}