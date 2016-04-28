<?php

namespace app\commands;

use app\models\City;
use app\models\Khlevents;
use app\models\Khlperiods;
use app\models\Khlteams;
use app\models\Khlplayers;
use app\models\Khlmatches;
use app\models\Matches;
use yii\base\ErrorException;
use yii\console\Controller;
use app\components\DocxConverter;
use app\models\Country;
use app\models\Articles;
use Yii;
use yii\helpers\Url;
use app\components\TranslateHelper;


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

        $url = Url::to("/home/romanych/football_hockey_bds/khl/khl_2015_2016_08");

        $content = file_get_contents($url);
        //echo $content; exit;
        $thisMatch = [];
        $matchId = 0;

        $chars = preg_split('/div id=\"detcon\"/', $content, -1, PREG_SPLIT_NO_EMPTY); //разделяем контент на матчи
        $j = count($chars);


        for ($m = 1; $m < $j; $m++) {

            $head = file_get_contents(Url::to("@app/commands/header.html"));
            $match = $head . $chars[$m]; //добавляем хэдер
            $thisMatch = $this->headOfMatchInArray($match);
           //print_r($thisMatch); exit;

            $game = new Khlmatches();
            $game->host_id = $thisMatch["host"];
            $game->guest_id = $thisMatch["guest"];
            $game->host_g = $thisMatch["host_g"];
            $game->guest_g = $thisMatch["guest_g"];
            $game->prim = $thisMatch["status"];
            try {
                $game->players = implode(",", $thisMatch["sost"][0]);
            } catch (ErrorException $e) {
                $game->players = $e->getMessage();
            }
            try {
                $game->player_off = implode(",", $thisMatch["sost"][1]);
            } catch (ErrorException $e) {
                $game->player_off = $e->getMessage();
            }
            //print_r($thisMatch); exit;

            $game->shot_in_goals_host = self::getIdOfPeriodsAfterIn($thisMatch["shot_in_goals_host"]);
            $game->shot_in_goals_guest = self::getIdOfPeriodsAfterIn($thisMatch["shot_in_goals_guest"]);
            $game->shot_reflected_host = self::getIdOfPeriodsAfterIn($thisMatch["shot_reflected_host"]);
            $game->shot_reflected_guest = self::getIdOfPeriodsAfterIn($thisMatch["shot_reflected_guest"]);
            $game->removal_host = self::getIdOfPeriodsAfterIn($thisMatch["removal_host"]);
            $game->removal_guest = self::getIdOfPeriodsAfterIn($thisMatch["removal_guest"]);
            $game->penalty_time_host = self::getIdOfPeriodsAfterIn($thisMatch["penalty_time_host"]);
            $game->penalty_time_guest = self::getIdOfPeriodsAfterIn($thisMatch["penalty_time_guest"]);
            $game->goals_in_more_host = self::getIdOfPeriodsAfterIn($thisMatch["goals_in_more_host"]);
            $game->goals_in_more_guest = self::getIdOfPeriodsAfterIn($thisMatch["goals_in_more_guest"]);
            $game->goals_in_less_host = self::getIdOfPeriodsAfterIn($thisMatch["goals_in_less_host"]);
            $game->goals_in_less_guest = self::getIdOfPeriodsAfterIn($thisMatch["goals_in_less_guest"]);
            $game->force_dodge_host = self::getIdOfPeriodsAfterIn($thisMatch["force_dodge_host"]);
            $game->force_dodge_guest = self::getIdOfPeriodsAfterIn($thisMatch["force_dodge_guest"]);
            $game->facedown_vic_host = self::getIdOfPeriodsAfterIn($thisMatch["facedown_vic_host"]);
            $game->facedown_vic_guest = self::getIdOfPeriodsAfterIn($thisMatch["facedown_vic_guest"]);

            $game->bet_vic_host = $thisMatch["bet_vic_host"];
            $game->bet_nobody = $thisMatch["bet_nobody"];
            $game->bet_vic_guest = $thisMatch["bet_vic_guest"];
            $game->date = $thisMatch["date"];
            $game->time_beg = $thisMatch["time_beg"];
            $game->judges = $thisMatch["judges"];
            $game->audience = $thisMatch["audience"];
            $game->stadium = $thisMatch["stadium"];

            $gk = [];
            $sub_sec = 0;

            if(isset($thisMatch["gk_substitution"][1])) {

                $game->gk_substitution = implode(',', $thisMatch["gk_substitution"][1]);
                $subs = explode(" ", $game->gk_substitution);
                //var_dump($subs); exit;
                $current_per = explode(":", $subs[3]);
                $sub_sec = (self::onlyDigit($subs[0]) - 1) * 1200 + (int)$current_per[0] * 60 + (int)$current_per[1];
                //var_dump($subs[4]." ".$subs[5]); exit;
                $gk[1][][$sub_sec] = Khlplayers::find()->where("name like('%" . self::clearSubject($subs[4] . " " . $subs[5]) . "%')")->one()->id;
                $gk[1][][3900] = Khlplayers::find()->where("name like('%" . self::clearSubject($subs[6] . " " . $subs[7]) . "%')")->one()->id;
                //var_dump($gk); exit;
            }
            if(isset($thisMatch["gk_substitution"][0])) {

                $game->gk_substitution = implode(',', $thisMatch["gk_substitution"][0]);
                $subs = explode(" ", $game->gk_substitution);
                //var_dump($subs); exit;
                $current_per = explode(":", $subs[3]);
                $sub_sec = (self::onlyDigit($subs[0]) - 1) * 1200 + (int)$current_per[0] * 60 + (int)$current_per[1];
                //var_dump($subs[4]." ".$subs[5]); exit;
                $gk[0][][$sub_sec] = Khlplayers::find()->where("name like('%" . self::clearSubject($subs[4] . " " . $subs[5]) . "%')")->one()->id;
                $gk[0][][3900] = Khlplayers::find()->where("name like('%" . self::clearSubject($subs[6] . " " . $subs[7]) . "%')")->one()->id;
                //var_dump($gk); exit;
            }
            else $game->gk_substitution = '';


            $game->errors = implode("; ", $thisMatch["errors"]);
            //var_dump($game); exit;


            $game->save(false);
            $matchId = $game->id;
            //var_dump($game->id); exit;

            $arrOfEvents = $this->eventOfMatchInArray($match);

            foreach ($arrOfEvents as $arr) {

                //print_r($arr);

                //$game->save(false); exit;
                $event = new Khlevents();
                if (isset($arr["time"])) {
                    $current_period = explode(":", $arr["time"]);
                    $event->minute = ($arr["period"] - 1) * 1200 + (int)$current_period[0] * 60 + (int)$current_period[1];

                } else $event->minute = 3900;

                $event->status = $arr["status"];
                $event->is_host = $arr["is_host"];
                try {
                    $event->player_id = (int)$arr["subject"];
                } catch (ErrorException $e) {
                    $event->player_id = 947;
                }
                $event->match_id = $matchId;
                if (isset($arr["prim"])) $event->prim = $arr["prim"];
                if (isset($arr["assist"])) $event->assist = implode(",", $arr["assist"]);
                //print_r($gk[0]);

                if ($event->is_host) {

                    if(isset($gk[1]) && key($gk[1][0]) >= $event->minute) $event->gk = $gk[1][0][$sub_sec];
                    elseif(isset($gk[1]) && key($gk[1][1]) >= $event->minute) $event->gk = $gk[1][1][3900];
                    else
                        try {
                            $event->gk = Khlplayers::find()->where("name like('%" . self::clearSubject($thisMatch["gk"][0][1][0]) . "%')")->one()->id;
                        } catch (ErrorException $e) {
                            $event->gk = 947;
                        }
                }
                if($event->is_host == 0) { //var_dump($thisMatch["gk"]); exit;
                    if(isset($gk[0]) && key($gk[0][0]) >= $event->minute) $event->gk = $gk[0][0][$sub_sec];
                    elseif(isset($gk[0]) && key($gk[0][1]) >= $event->minute) $event->gk = $gk[0][1][3900];
                    else
                        try {
                            $event->gk = Khlplayers::find()->where("name like('%" . self::clearSubject($thisMatch["gk"][0][0][0]) . "%')")->one()->id;
                        } catch (ErrorException $e) {
                            $event->gk = 947;
                        }
                }
                //var_dump($event);
                $event->save(false);

            }


        }

    }

    /**
     * Несколько вспомагательных методов
     */
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

        return  preg_replace("/[^ЦСДМЮЙВЛТХКАБНПабвгдеёжзийклмнопрстуфхчцшщъыьэюя\s-]+/", "", $string);
    }

    public static function clearTwoWordsString($string){

        return  self::manySReplaceByOne(preg_replace("/[^ЦСДМЮЙВЛТХКАБНПРабвгдеёжзийклмнопрстуфхчцшщъыьэюяA-Za-z \t-]+/", "", $string));
    }

    public static function clearSubject($string){
        return  preg_replace("/[^A-Za-z\s]/", "", $string);
    }

    public static function sOff($string){
        return  preg_replace("/\s/", "", $string);
    }

    public static function manySReplaceByOne($string){
        return  preg_replace("/[\s]+/", " ", $string);
    }

    public static function cutDotEnd($string){
        return substr($string, 0, strpos($string,'.'));
    }

    public static function onlyDigit($string){
        return preg_replace("/[^0-9\s]/", "", $string);
    }


    /**
     * Возвращает массив событий матча
     * @param $match
     * @return array
     * @throws
     * статусы 1 - гол, 2 - 2х минутное удаление, 3 - гол в серии булитов, 4 - нереализованный буллит
     */
    private function eventOfMatchInArray($match)
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
        $gameOff = 0;
        $host = 0;


        $node = $xpath->query(".//*/td[@class='tname-home logo-enable']/span[@class='tname']/a")->item(0);
        //var_dump($node); exit;
        try {
            $arr['host'] = Khlteams::find()->where("name like('%" . self::clearTwoWordsString($node->textContent) . "%')")->one()->id;
            $arr['errors'][] = '';
        } catch (ErrorException $e) {
            $arr['host'] = 29; //null
            $arr['errors'][] = 'Хозяин не схвачен: '.$node->textContent;
            //var_dump(self::clearString($node->textContent)); exit;
        }
        $node = $xpath->query(".//*/td[@class='tname-away logo-enable']")->item(0);
        try {
            $arr['guest'] = Khlteams::find()->where("name like('%" . self::clearString($node->firstChild->textContent) . "%')")->one()->id;
        } catch (ErrorException $e) {
            $arr['guest'] = 29; //null
            $arr['errors'][] = 'Гость не схвачен: '.$node->firstChild->textContent;
            //var_dump(self::clearString($node->firstChild->textContent)); exit;
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
            $arr['stadium'] = self::sOff(substr($st[1], strpos($st[1],':')+2));

        $node = $xpath->query(".//*/table[@id='parts']")->item(2)->firstChild;
        $first = $node->firstChild;
        $i = 0;
        while ($first = $first->nextSibling) {

            if($first->childNodes) {

                foreach ($first->childNodes as $nodde) {
                    if($nodde->textContent == "Замены") $gameOff = 1;
                    if($nodde->textContent == "Тренеры") $gameOff = 0;
                    if($nodde->attributes) {
                        foreach ($nodde->attributes as $attr) {
                            if ($attr->value == "summary-vertical fl") $host = 1;
                            if ($attr->value == "summary-vertical fr") $host = 0;
                        }
                    }
                    //var_dump($nodde->textContent); exit;
                    if($nodde->childNodes) {
                        foreach ($nodde->childNodes as $child) {

                            if ($child->attributes) {
                                foreach ($child->attributes as $attribute) {

                                    if($attribute->value == "name") {
                                       // $arr['sost'][$gameOff][] = $child->textContent;
                                        if(preg_match("/(В)/",$child->textContent)) $arr['gk'][$gameOff][$host][] =  self::cutDotEnd($child->textContent);
                                        try {
                                            $arr['sost'][$gameOff][] = Khlplayers::find()->where("name like('%" . self::cutDotEnd($child->textContent) . "%')")->one()->id;
                                        } catch (ErrorException $e) {
                                            //$arr['sost'][$gameOff][] = 947;
                                            //$arr['errors'][] = $child->textContent.' не попал в состав по ошибке';
                                            $new_player = new Khlplayers();
                                            $new_player->name = self::clearTwoWordsString($child->textContent);
                                            if($host)$new_player->team_id = $arr['host'];
                                            else $new_player->team_id = $arr['guest'];
                                            $new_player->country_id = 162;
                                            $new_player->save(false);
                                            $arr['sost'][$gameOff][] = $new_player->id;
                                        }

                                    }

                                    if($attribute->nodeName == "title" && isset($child->firstChild->attributes)) {
                                        foreach($child->firstChild->attributes as $chAttr) {
                                            if($chAttr->value == "icon substitution-out")
                                                $arr['gk_substitution'][$host][] = $attribute->value;
                                        }

                                   }
                                }
                            }
                        }

                    }

                }

            }

        }

        $stats = $xpath->query(".//*/div[@id='tab-statistics-0-statistic']")->item(0)->firstChild;
        var_dump($stats);


        while ($stats = $stats->nextSibling) {
            var_dump($stats); exit;
            if($stats->childNodes) {

                foreach ($stats->childNodes as $nodde) {
                    //var_dump($nodde); exit;
                    if($nodde->childNodes) {

                        foreach ($nodde->childNodes as $nod) {

                            if($nod->childNodes) {
                                //var_dump($nod); exit;

                                foreach ($nod->childNodes as $n) {

                                    if($n->childNodes) {

                                        foreach ($n->childNodes as $new) {
                                           if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                               && $new->parentNode->nextSibling->nextSibling->textContent == "Броски в створ ворот")
                                                    $arr['shot_in_goals_host'][0]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Броски в створ ворот")
                                                    $arr['shot_in_goals_guest'][0]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Отраженные броски")
                                                $arr['shot_reflected_host'][0]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Отраженные броски")
                                                $arr['shot_reflected_guest'][0]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Удаления")
                                                $arr['removal_host'][0]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Удаления")
                                                $arr['removal_guest'][0]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Штрафное время")
                                                $arr['penalty_time_host'][0]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Штрафное время")
                                                $arr['penalty_time_guest'][0]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Шайбы в большинстве")
                                                $arr['goals_in_more_host'][0]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Шайбы в большинстве")
                                                $arr['goals_in_more_guest'][0]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Шайбы в меньшинстве")
                                                $arr['goals_in_less_host'][0]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Шайбы в меньшинстве")
                                                $arr['goals_in_less_guest'][0]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Силовые приемы")
                                                $arr['force_dodge_host'][0]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Силовые приемы")
                                                $arr['force_dodge_guest'][0]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Выигр. вбрасывания")
                                                $arr['facedown_vic_host'][0]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Выигр. вбрасывания")
                                                $arr['facedown_vic_guest'][0]  = (int)$new->textContent;


                                        }
                                    }

                                }
                            }

                        }
                    }
                }
            }
        }

        $stats = $xpath->query(".//*/div[@id='tab-statistics-1-statistic']")->item(0)->firstChild;
        //var_dump($stats);

        while ($stats = $stats->nextSibling) {
            //var_dump($stats);
            if($stats->childNodes) {

                foreach ($stats->childNodes as $nodde) {
                    //var_dump($nodde);
                    if($nodde->childNodes) {

                        foreach ($nodde->childNodes as $nod) {
                            //var_dump($nod); exit;
                            if($nod->childNodes) {

                                foreach ($nod->childNodes as $n) {

                                    if($n->childNodes) {

                                        foreach ($n->childNodes as $new) {
                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Броски в створ ворот")
                                                $arr['shot_in_goals_host'][1]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Броски в створ ворот")
                                                $arr['shot_in_goals_guest'][1]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Отраженные броски")
                                                $arr['shot_reflected_host'][1]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Отраженные броски")
                                                $arr['shot_reflected_guest'][1]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Удаления")
                                                $arr['removal_host'][1]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Удаления")
                                                $arr['removal_guest'][1]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Штрафное время")
                                                $arr['penalty_time_host'][1]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Штрафное время")
                                                $arr['penalty_time_guest'][1]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Шайбы в большинстве")
                                                $arr['goals_in_more_host'][1]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Шайбы в большинстве")
                                                $arr['goals_in_more_guest'][1]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Шайбы в меньшинстве")
                                                $arr['goals_in_less_host'][1]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Шайбы в меньшинстве")
                                                $arr['goals_in_less_guest'][1]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Силовые приемы")
                                                $arr['force_dodge_host'][1]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Силовые приемы")
                                                $arr['force_dodge_guest'][1]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Выигр. вбрасывания")
                                                $arr['facedown_vic_host'][1]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Выигр. вбрасывания")
                                                $arr['facedown_vic_guest'][1]  = (int)$new->textContent;


                                        }
                                    }

                                }
                            }

                        }
                    }
                }
            }
        }

        $stats = $xpath->query(".//*/div[@id='tab-statistics-2-statistic']")->item(0)->firstChild;
        //var_dump($stats);

        while ($stats = $stats->nextSibling) {
            //var_dump($stats);
            if($stats->childNodes) {

                foreach ($stats->childNodes as $nodde) {
                    //var_dump($nodde);
                    if($nodde->childNodes) {

                        foreach ($nodde->childNodes as $nod) {
                            //var_dump($nod); exit;
                            if($nod->childNodes) {

                                foreach ($nod->childNodes as $n) {

                                    if($n->childNodes) {

                                        foreach ($n->childNodes as $new) {
                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Броски в створ ворот")
                                                $arr['shot_in_goals_host'][2]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Броски в створ ворот")
                                                $arr['shot_in_goals_guest'][2]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Отраженные броски")
                                                $arr['shot_reflected_host'][2]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Отраженные броски")
                                                $arr['shot_reflected_guest'][2]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Удаления")
                                                $arr['removal_host'][2]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Удаления")
                                                $arr['removal_guest'][2]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Штрафное время")
                                                $arr['penalty_time_host'][2]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Штрафное время")
                                                $arr['penalty_time_guest'][2]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Шайбы в большинстве")
                                                $arr['goals_in_more_host'][2]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Шайбы в большинстве")
                                                $arr['goals_in_more_guest'][2]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Шайбы в меньшинстве")
                                                $arr['goals_in_less_host'][2]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Шайбы в меньшинстве")
                                                $arr['goals_in_less_guest'][2]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Силовые приемы")
                                                $arr['force_dodge_host'][2]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Силовые приемы")
                                                $arr['force_dodge_guest'][2]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Выигр. вбрасывания")
                                                $arr['facedown_vic_host'][2]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Выигр. вбрасывания")
                                                $arr['facedown_vic_guest'][2]  = (int)$new->textContent;


                                        }
                                    }

                                }
                            }

                        }
                    }
                }
            }
        }

        $stats = $xpath->query(".//*/div[@id='tab-statistics-3-statistic']")->item(0)->firstChild;
        //var_dump($stats);

        while ($stats = $stats->nextSibling) {
            //var_dump($stats);
            if($stats->childNodes) {

                foreach ($stats->childNodes as $nodde) {
                    //var_dump($nodde);
                    if($nodde->childNodes) {

                        foreach ($nodde->childNodes as $nod) {
                            //var_dump($nod); exit;
                            if($nod->childNodes) {

                                foreach ($nod->childNodes as $n) {

                                    if($n->childNodes) {

                                        foreach ($n->childNodes as $new) {
                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Броски в створ ворот")
                                                $arr['shot_in_goals_host'][3]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Броски в створ ворот")
                                                $arr['shot_in_goals_guest'][3]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Отраженные броски")
                                                $arr['shot_reflected_host'][3]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Отраженные броски")
                                                $arr['shot_reflected_guest'][3]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Удаления")
                                                $arr['removal_host'][3]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Удаления")
                                                $arr['removal_guest'][3]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Штрафное время")
                                                $arr['penalty_time_host'][3]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Штрафное время")
                                                $arr['penalty_time_guest'][3]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Шайбы в большинстве")
                                                $arr['goals_in_more_host'][3]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Шайбы в большинстве")
                                                $arr['goals_in_more_guest'][3]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Шайбы в меньшинстве")
                                                $arr['goals_in_less_host'][3]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Шайбы в меньшинстве")
                                                $arr['goals_in_less_guest'][3]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Силовые приемы")
                                                $arr['force_dodge_host'][3]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Силовые приемы")
                                                $arr['force_dodge_guest'][3]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Выигр. вбрасывания")
                                                $arr['facedown_vic_host'][3]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Выигр. вбрасывания")
                                                $arr['facedown_vic_guest'][3]  = (int)$new->textContent;


                                        }
                                    }

                                }
                            }

                        }
                    }
                }
            }
        }
        if(isset($xpath->query(".//*/td[@class='kx o_1']")->item(0)->firstChild->nextSibling)) {
            $bet1 = $xpath->query(".//*/td[@class='kx o_1']")->item(0)->firstChild->nextSibling;
            $arr["bet_vic_host"] = $bet1->textContent;
        }
        else $arr["bet_vic_host"] = 0;

        if(isset($xpath->query(".//*/td[@class='kx o_0 winner']")->item(0)->firstChild->nextSibling)){
            $bet2 = $xpath->query(".//*/td[@class='kx o_0 winner']")->item(0)->firstChild->nextSibling;
            $arr["bet_nobody"] = $bet2->textContent;
        }
        else $arr["bet_nobody"] = 0;

        if(isset($xpath->query(".//*/td[@class='kx o_2']")->item(0)->firstChild->nextSibling)) {
            $bet3 = $xpath->query(".//*/td[@class='kx o_2']")->item(0)->firstChild->nextSibling;
            $arr["bet_vic_guest"] = $bet3->textContent;
        }
        else  $arr["bet_vic_guest"] = 0;
        //var_dump($arr['gk']); exit;

        if(isset($xpath->query(".//*/div[@id='tab-statistics-4-statistic']")->item(0)->firstChild))
            $stats = $xpath->query(".//*/div[@id='tab-statistics-4-statistic']")->item(0)->firstChild;
        else  return $arr;
        //var_dump($stats);

        while ($stats = $stats->nextSibling) {
            //var_dump($stats);
            if($stats->childNodes) {

                foreach ($stats->childNodes as $nodde) {
                    //var_dump($nodde);
                    if($nodde->childNodes) {

                        foreach ($nodde->childNodes as $nod) {
                            //var_dump($nod); exit;
                            if($nod->childNodes) {

                                foreach ($nod->childNodes as $n) {

                                    if($n->childNodes) {

                                        foreach ($n->childNodes as $new) {
                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Броски в створ ворот")
                                                $arr['shot_in_goals_host'][4]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Броски в створ ворот")
                                                $arr['shot_in_goals_guest'][4]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Отраженные броски")
                                                $arr['shot_reflected_host'][4]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Отраженные броски")
                                                $arr['shot_reflected_guest'][4]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Удаления")
                                                $arr['removal_host'][4]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Удаления")
                                                $arr['removal_guest'][4]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Штрафное время")
                                                $arr['penalty_time_host'][4]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Штрафное время")
                                                $arr['penalty_time_guest'][4]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Шайбы в большинстве")
                                                $arr['goals_in_more_host'][4]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Шайбы в большинстве")
                                                $arr['goals_in_more_guest'][4]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Шайбы в меньшинстве")
                                                $arr['goals_in_less_host'][4]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Шайбы в меньшинстве")
                                                $arr['goals_in_less_guest'][4]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Силовые приемы")
                                                $arr['force_dodge_host'][4]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Силовые приемы")
                                                $arr['force_dodge_guest'][4]  = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->nextSibling->nextSibling)
                                                && $new->parentNode->nextSibling->nextSibling->textContent == "Выигр. вбрасывания")
                                                $arr['facedown_vic_host'][4] = (int)$new->textContent;

                                            if($new->nodeName == "div" && strlen($new->textContent) < 3 && isset($new->parentNode->previousSibling->previousSibling)
                                                && $new->parentNode->previousSibling->previousSibling->textContent == "Выигр. вбрасывания")
                                                $arr['facedown_vic_guest'][4]  = (int)$new->textContent;


                                        }
                                    }

                                }
                            }

                        }
                    }
                }
            }
        }



        return $arr;

    }

    /**
     * Полученин айдишника набора периодов матча при помещении в таблицу матчей
     * @param $arrOfPeriods
     * @return int
     */
    private static function getIdOfPeriodsAfterIn($arrOfPeriods){
        $periods = new Khlperiods();
        $periods->match = $arrOfPeriods[0];
        $periods->first = $arrOfPeriods[1];
        $periods->second = $arrOfPeriods[2];
        $periods->third = $arrOfPeriods[3];
        if(isset($arrOfPeriods[4])) $periods->overtime = $arrOfPeriods[4];
        else $periods->overtime = 0;
        $periods->save(false);

        return $periods->id;

    }






}