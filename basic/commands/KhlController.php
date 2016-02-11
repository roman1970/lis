<?php

namespace app\commands;

use app\models\City;
use app\models\Khlteams;
use app\models\Khlplayers;
use app\models\Matches;
use yii\base\ErrorException;
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
     * Заполнение таблицы Игроков
     */
    public function actionFillPlayers(){
        $status = 0;
        $country = 0;

        $i = 0;
        $url = Url::to("@app/commands/sost.html");
        $content = file_get_contents($url);

        $chars = preg_split('/diretta-content/', $content, -1, PREG_SPLIT_NO_EMPTY); //разделяем контент на матчи

        array_shift($chars);

        foreach($chars as $teamdom) {
            $arr = [];

            $dom = new \DomDocument();
            libxml_use_internal_errors(true);
            $head = file_get_contents(Url::to("@app/commands/header.html"));
            $match = $head . $teamdom; //добавляем хэдер
            $dom->loadHTML($match);
            $dom->preserveWhiteSpace = true;

            $xpath = new \DOMXPath($dom);

            $nodeTeamName = $xpath->query(".//*/div[@class='team-name']")->item(0);
            var_dump($nodeTeamName->nodeValue);
            $teamId = Khlteams::find()->where("name like('%".$nodeTeamName->nodeValue."%')")->one()->id;
            //->where("name like('%".$nodeTeamName->nodeValue."%') or guest like('%".$team."%')")
            //var_dump($teamId);
            $nodeStatus = $xpath->query(".//*/tr[@class='player-type-title']")->item(0);
            if ($nodeStatus->textContent == "Вратари") $status = 1;
            //var_dump($status);

            while ($nodeStatus = $nodeStatus->nextSibling) {
                if ($nodeStatus->attributes) {
                    foreach ($nodeStatus->attributes as $attribute) {

                        if ($attribute->value == "player-type-title" && $nodeStatus->textContent == "Защитники") {
                            $status = 2;
                        }
                        if ($attribute->value == "player-type-title" && $nodeStatus->textContent == "Нападающие") {
                            $status = 3;
                        }
                        if ($attribute->value == "player-type-title" && $nodeStatus->textContent == "Тренер") {
                            $status = 4;
                        }

                    }
                }

                foreach ($nodeStatus->childNodes as $nodde) {

                    if ($nodde->attributes) {
                        foreach ($nodde->attributes as $attribute) {
                            if ($attribute->value == "jersey-number") $arr[$i]['number'] = (int)$nodde->textContent;
                            if ($attribute->value == "player-name") {
                                $arr[$i]['name'] = $nodde->textContent;
                                $f = 0;
                                foreach ($nodde->firstChild->attributes as $attr) {
                                    if ($f == 0)
                                        $country = Country::find()->where(['name' => $attr->nodeValue])->one()->id;
                                    $f++;
                                };

                                $arr[$i]['status'] = $status;
                                $arr[$i]['team'] = $teamId;
                                $arr[$i]['country'] = $country;
                            }
                        }
                    }
                }

                $i++;
            }

            foreach($arr as $rec){
                $player = new Khlplayers();
                $player->name = $rec['name'];
                $player->team_id = $rec['team'];
                $player->status = $rec['status'];
                $player->number = $rec['number'];
                $player->country_id = $rec['country'];

                $player->save(false);

            }
            //var_dump($arr);

        }

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
            //print_r($this->eventOfMatchInArray($match));

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
        return  preg_replace("/[^СДМЮЙВЛТХКАБНПабвгдеёжзийклмнопрстуфхчцшщъыьэюя\s-]+/", "", $string);
    }

    public static function clearSubject($string){
        return  preg_replace("/[^A-Za-z\s]/", "", $string);
    }

    public static function sOff($string){
        return  preg_replace("/\s/", "", $string);
    }


    /**
     * Возвращает массив событий матча
     * @param $match
     * @return array
     * @throws
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
        $com = 0;


        while ($node = $node->nextSibling) {
            $ar_as = [];
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
                        if($attribute->value == "summary-vertical fl") $com = 1;
                        if($attribute->value == "summary-vertical fr") $com = 0;
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
                                    $arr[$i]['is_host'] = $com;
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
                                            //$arr[$i]['subject'] = trim($grandson->textContent);
                                            try {
                                                $arr[$i]['subject'] = Khlplayers::find()->where("name like('%" . self::clearSubject($grandson->textContent) . "%')")->one()->id;
                                            } catch (ErrorException $e) {
                                                $arr[$i]['subject'] = 947;
                                            }
                                           // var_dump(self::cutDot($grandson->textContent)); exit;
                                        }
                                        if($attribute->value == "assist") {
                                            $ar_as = explode('+', $grandson->textContent);
                                            //var_dump($ar_as); exit;
                                            foreach ($ar_as as $ass) {
                                                //var_dump(trim(self::clearSubject($ass)));
                                                try {
                                                    $arr[$i]['assist'][] = Khlplayers::find()->where("name like('%" . trim(self::clearSubject($ass)) . "%')")->one()->id;
                                                } catch (ErrorException $e) {
                                                    $arr[$i]['assist'][] = 947;
                                                }
                                            }

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
        try {
            $arr['host'] = Khlteams::find()->where("name like('%" . self::clearString($node->textContent) . "%')")->one()->id;
        } catch (ErrorException $e) {
            $arr['host'] = 29; //null
        }
        $node = $xpath->query(".//*/td[@class='tname-away logo-enable']")->item(0);
        try {
            $arr['guest'] = Khlteams::find()->where("name like('%" . self::clearString($node->firstChild->textContent) . "%')")->one()->id;
        } catch (ErrorException $e) {
            $arr['guest'] = 29; //null
        }
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
            $arr['judges'] = substr($node->nextSibling->firstChild->textContent, strpos($node->nextSibling->firstChild->textContent,':')+2);
            $st = explode(',', $node->nextSibling->nextSibling->firstChild->textContent);
            $arr['audience'] = (int)self::sOff(substr($st[0], strpos($st[0],':')+2));
            $arr['stadium'] = substr($st[1], strpos($st[1],':')+2);

        $node = $xpath->query(".//*/table[@id='parts']")->item(2)->firstChild;
        $first = $node->firstChild;
        $i = 0;
        while ($first = $first->nextSibling) {


               // var_dump($first); exit;
            if($first->childNodes) {
                foreach ($first->childNodes as $nodde) {
                    //var_dump($nodde->textContent); exit;
                    if($nodde->childNodes) {
                        foreach ($nodde->childNodes as $child) {

                            if ($child->attributes) {
                                foreach ($child->attributes as $attribute) {
                                    if($attribute->value == "name") $arr['sost'][$i][] = $child->textContent;
                                    if($attribute->value == "name-substitution") $arr['sost'][$i][] = $child->textContent;
                                    if($attribute->value == "icon-lineup") {var_dump($attribute);exit;}
                                }
                            }
                        }

                    }
                    $i++;
                }

            }

        }


        return $arr;

    }






}