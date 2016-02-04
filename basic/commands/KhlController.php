<?php

namespace app\commands;

use app\models\City;
use app\models\Khlteams;
use app\models\Khlplayers;
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

    public function actionFillPlayers(){
        $url = Url::to("@app/commands/sost.html");
        $content = file_get_contents($url);

        //$chars = preg_split('/div id=\"detcon\"/', $content, -1, PREG_SPLIT_NO_EMPTY); //разделяем контент на матчи
        //$j = count($chars);

        $dom = new \DomDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($content);
        $dom->preserveWhiteSpace = true;

        $xpath = new \DOMXPath($dom);

        $node = $xpath->query(".//*/div[@class='team-name']")->item(0);

        var_dump($node->nodeValue);

    }

    /**
     * Добавление новых матчей в КХЛ
     */
    public function actionAddNewMatches()
    {

        $url = Url::to("@app/commands/khl.html");
        $content = file_get_contents($url);

        $chars = preg_split('/div id=\"detcon\"/', $content, -1, PREG_SPLIT_NO_EMPTY); //разделяем контент на матчи
        $j = count($chars);


        for ($m = 1; $m < $j; $m++) {
            $head = file_get_contents(Url::to("@app/commands/header.html"));
            $match = $head . $chars[$m]; //добавляем хэдер
            print_r($this->headOfMatchInArray($match));
            print_r($this->eventOfMatchInArray($match));

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

    /**
     * Возвращает массив событий матча
     * @param $match
     * @return array
     * статусы 1 - гол, 2 - 2х минутное удаление, 3 - гол в серии булитов, 4 - нереализованный буллит
     */
    private static function eventOfMatchInArray($match)
    {
        $dom = new \DomDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($match);
        $dom->preserveWhiteSpace = true;

        $xpath = new \DOMXPath($dom);

        $node = $xpath->query(".//*/tr[@class='stage-header stage-14']")->item(0);
       // var_dump($els);
        $arr = [];
        $i = 0;
        $period = 1;
        $com = '';


        while ($node = $node->nextSibling) {
            //$arr[$i]['period'] = 1;
            //var_dump($node->childNodes);
            foreach ($node->childNodes as $nodde) {
                //var_dump($nodde->textContent); //== "2-й период")
                if($nodde->attributes){
                    foreach ($nodde->attributes as $attribute) {

                        if($attribute->value == "h-part" && $nodde->textContent == "2-й период") $period = 2;
                        if($attribute->value == "h-part" && $nodde->textContent == "3-й период") $period = 3;
                        if($attribute->value == "h-part" && $nodde->textContent == "Овертайм") $period = 4;
                        if($attribute->value == "h-part" && $nodde->textContent == "Буллиты") $period = 5;
                        if($attribute->value == "summary-vertical fl") $com = 'host';
                        if($attribute->value == "summary-vertical fr") $com = 'guest';
                    }
                }

               //var_dump($nodde->childNodes);
                if($nodde->childNodes) {


                    foreach ($nodde->childNodes as $child) {

                            //var_dump($child); exit;
                        if($child->attributes){
                            foreach ($child->attributes as $attribute) {
                                //if($attribute->value == "wrapper" && $child->textContent == "(Буллит)") echo "бул"; //$arr[]['score'] = $child->textContent;
                            }
                        }
                        if($child->childNodes){
                            foreach ($child->childNodes as $grandson) {
                                if($grandson->attributes){
                                    $arr[$i]['period'] = $period;
                                    $arr[$i]['com'] = $com;
                                    foreach ($grandson->attributes as $attribute) {
                                        if($attribute->value == "time-box-wide") $arr[$i]['time'] = $grandson->textContent;
                                        if($attribute->value == "icon-box hockey-penalty-2") {
                                            $arr[$i]['status'] = 2;
                                        }
                                        if($attribute->value == "icon-box hockey-ball") {
                                            if($period == 5)
                                                $arr[$i]['status'] = 3;
                                            else
                                                $arr[$i]['status'] = 1;
                                        }
                                        if($attribute->value == "icon-box penalty-missed") {
                                            $arr[$i]['status'] = 4;
                                        }
                                        if($attribute->value == "subincident-penalty") {
                                            $arr[$i]['prim'] = $grandson->textContent;
                                        }
                                        if($attribute->value == "participant-name") {
                                            $arr[$i]['subject'] = trim($grandson->textContent);
                                        }
                                        if($attribute->value == "assist") {
                                            $arr[$i]['assist'] = trim($grandson->textContent);
                                        }


                                    }
                                }
                            }
                        }


                    }
                }

            }
        $i++;
        }
        return $arr;

    }


    /**
     * Возвращает массив основных событий матча
     * @param $match
     * @return array
     */
    private static function  headOfMatchInArray($match){
        $dom = new \DomDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($match);
        $dom->preserveWhiteSpace = true;
        $xpath = new \DOMXPath($dom);
        $arr=[];
        $date = '';
        $st = '';

        $node = $xpath->query(".//*/td[@class='tname-home logo-enable']/span[@class='tname']/a")->item(0);
            $arr['host'] = $node->textContent;
        $node = $xpath->query(".//*/td[@class='tname-away logo-enable']")->item(0);
            $arr['guest'] = $node->firstChild->textContent;
        $node = $xpath->query(".//*/td[@class='current-result']/span[@class='scoreboard']")->item(0);
            $arr['host_g'] = $node->textContent;
            $arr['guest_g'] = $node->nextSibling->nextSibling->textContent;
        $node = $xpath->query(".//*/td[@id='utime']")->item(0);
            $date = explode(' ',$node->textContent);
            $arr['date'] = $date[0];
            $arr['time_beg'] = $date[1];
        $node = $xpath->query(".//*/td[@class='mstat']")->item(0);
            $arr['status'] = $node->textContent;
        $node = $xpath->query(".//*/tr[@class='stage-header']")->item(0);
            $arr['judge'] = $node->nextSibling->firstChild->textContent;
            $st = explode(',', $node->nextSibling->nextSibling->firstChild->textContent);
            $arr['audience'] = $st[0];
            $arr['stadium'] = $st[1];

        return $arr;

    }




}