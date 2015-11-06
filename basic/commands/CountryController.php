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


class CountryController extends Controller
{
    public $arr = [];

    public function actionIndex()
    {
        $methods = get_class_methods($this);
        echo 'Actions:' . "\r\n";
        foreach ($methods as $method)
            if (preg_match('/^action(.+)$/', $method, $match))
                echo ' - ' . $match[1] . "\r\n";
    }


    public function actionFillcountries()
    {
        $countries = Country::find()->all();

        foreach ($countries as $country) {
            if($country->id == 11) { $country->iso_code = 'ad'; $country->soccer_code = 19; $country->update(); }
        }

    }

    public function actionGettournaments(){
        $matches = Matches::find()
            ->all();
        foreach ($matches as $match) {
           $arr[] = $match->tournament;
        }

        print_r(array_unique($arr));
    }

    public function actionTransformFile(){
        $docObj = new DocxConverter(Url::to("web/uploads/file.docx"));

        $docText = $docObj->convertToText();

        $result = preg_split("/(\.poe\s|\.his\s|\.che\s|\.pc\s|\.pc-his\s|\.foo\s|\.pic\s|\.se\s|\.enc\s|\.mat\s|\.myt-gb\s|\.myt-gb\s)/",$docText, -1, PREG_SPLIT_DELIM_CAPTURE);
        $model = new Articles();
        $model->text = $result[0];
        $model->title = '';
        $model->alias = '';
        $model->site_id = 7;
        $model->cat_id = 57;
        $model->tags = '';
        $model->source_id = 2;

        if($model->save(false)) echo "Head copied";


    }

    /**
     * Добавление новых матчей в foo_matches
     */
    public function actionAddNewMatches(){

        $url = Url::to("@app/commands/tmpl.html");

        $content = file_get_contents($url);
        //var_dump(mb_detect_encoding($content, array('UTF-8', 'Windows-1251'), true)); exit;

        //$content = iconv(mb_detect_encoding($content, array('UTF-8', 'Windows-1251'), true), 'Windows-1251', $content);

        $content = str_replace(chr(9), '', $content);
        $content = str_replace(chr(11), '', $content);  // заменяем табуляцию на пробел
        $content = str_replace(chr(13), '', $content);
        $content = str_replace(chr(10), '', $content);

        $chars = preg_split('/div id=\"detcon\"/', $content, -1, PREG_SPLIT_NO_EMPTY); //разделяем контент на матчи
        $j = count($chars);



        for ($m = 0; $m < $j; $m++) {


            //инициализация переменных
            $tournament = ''; // турнир
            $host = ''; //номинальный хозяин
            $guest = ''; //номинальный гость
            $score = ''; //счёт
            $gett = 0; //голы, забитые хозяевами
            $lett = 0; //голы, забитые гостями
            $stay_h = ''; //расстановка хозяев
            $stay_g = ''; //расстановка гостей
            $date = ''; // дата
            $time = ''; // время начала матча
            $stra_h = '';
            $yel_kart_h = ''; //жёлтые карточки хозяев
            $yel_kart_g = ''; //жёлтые карточки гостей
            $red_kart_h = ''; //красные карточки хозяев
            $red_kart_g = ''; //красные карточки гостей
            $stra_h = ''; //расстановка
            $stra_g = '';
            $ud_h = 0; //удары
            $ud_g = 0;
            $ud_mim_h = 0; //удары мимо
            $ud_mim_g = 0;
            $offside_h = 0; //оффсайды
            $offside_g = 0;
            $falls_h = 0; //фолы
            $falls_g = 0;
            $ud_v_stv_h = 0; //Удары в створ
            $ud_v_stv_g = 0;
            $corner_h = 0; //Угловые
            $corner_g = 0;
            $saves_h = 0; //Сейвы
            $saves_g = 0;
            $yelkar_h = 0; //жёлтые карточки
            $yelkar_g = 0;
            $ballpos_h = 0; //владение мячом
            $ballpos_g = 0;
            $shtraf_h = 0; //штрафные
            $shtraf_g = 0;
            $outs_h = 0; //штрафные
            $outs_g = 0;
            $bet_g = 0.00;  //ставки
            $bet_h = 0.00;
            $bet_n = 0.00;
            $substit_h = ''; //строка замен хозяев
            $substit_g = ''; //строка замен гостен
            $goul_h = ''; //голы хозяев
            $goul_g = ''; //голы гостей
            $pen_miss_h = ''; //нереализованные пенальти хозяев
            $pen_miss_g = ''; //нереализованные пенальти гостей
            $prim = ''; //примечание
            $onehalf_h = 0; // голы хозяев в первой половине матча
            $onehalf_g = 0; // голы гостей в первой половине матча


            $dom = new \DomDocument();
            libxml_use_internal_errors(true);
            $head = file_get_contents(Url::to("@app/commands/header.html"));
            $match = $head . $chars[$m]; //добавляем хэдер

            $dom->loadHTML($match);


            $div = $dom->getElementsByTagName("div");
            foreach ($div as $node) {


                if ($node->getAttribute('class') === 'fleft') {
                    $tournament = $node->nodeValue;

                }



                if ($node->getAttribute('id') === 'tab-statistics-0-statistic')
                {
                    $dt = $node->nodeValue;
                    $dom_in = new \DomDocument();
                    $html = $node->ownerDocument->saveHTML($node);
                    libxml_use_internal_errors(true);
                    $newhtml = $head . $html;
                    $dom_in->loadHTML($newhtml);



                    $tr = $dom_in->getElementsByTagName("tr");


                    foreach ($tr as $node) {

                        if ($node->getAttribute('class') === 'odd'){
                            $odd = $node->nodeValue;


                            if (preg_match('/\vУдары\v/', $odd))  //в регулярке - вертикальный пробельный символ
                            {
                                $statistic = preg_split('/Удары/', $odd);

                                $ud_h = (int) $statistic[0];

                                $ud_g = (int)$statistic[1];


                            }

                            if (preg_match('/Удары мимо/', $odd))
                            {
                                $statistic = preg_split('/Удары мимо/', $odd);

                                $ud_mim_h = (int) $statistic[0];

                                $ud_mim_g = (int)$statistic[1];


                            }

                            if (preg_match('/Офсайды/', $odd))
                            {
                                $statistic = preg_split('/Офсайды/', $odd);

                                $offside_h = (int) $statistic[0];

                                $offside_g = (int)$statistic[1];


                            }

                            if (preg_match('/Фолы/', $odd))
                            {
                                $statistic = preg_split('/Фолы/', $odd);

                                $falls_h = (int) $statistic[0];

                                $falls_g = (int)$statistic[1];


                            }

                            if (preg_match('/Удары в створ/', $odd))
                            {
                                $statistic = preg_split('/Удары в створ/', $odd);

                                $ud_v_stv_h = (int) $statistic[0];

                                $ud_v_stv_g = (int)$statistic[1];


                            }

                            if (preg_match('/Угловые/', $odd))
                            {
                                $statistic = preg_split('/Угловые/', $odd);

                                $corner_h = (int) $statistic[0];

                                $corner_g = (int)$statistic[1];


                            }

                            if (preg_match('/Сэйвы/', $odd))
                            {
                                $statistic = preg_split('/Сэйвы/', $odd);

                                $saves_h = (int) $statistic[0];

                                $saves_g = (int)$statistic[1];


                            }

                            if (preg_match('/Желтые карточки/', $odd))
                            {
                                $statistic = preg_split('/Желтые карточки/', $odd);

                                $yelkar_h = (int) $statistic[0];

                                $yelkar_g = (int)$statistic[1];


                            }

                            if (preg_match('/Владение мячом/', $odd))
                            {
                                $statistic = preg_split('/Владение мячом/', $odd);

                                $ballpos_h = (int) $statistic[0];

                                $ballpos_g = (int)$statistic[1];

                            }

                            if (preg_match('/Штрафные/', $odd))
                            {
                                $statistic = preg_split('/Штрафные/', $odd);

                                $shtraf_h = (int) $statistic[0];

                                $shtraf_g = (int)$statistic[1];

                            }

                            if (preg_match('/Вбрасывания/', $odd))
                            {
                                $statistic = preg_split('/Вбрасывания/', $odd);

                                $outs_h = (int) $statistic[0];

                                $outs_g = (int)$statistic[1];

                            }

                        }
                    }

                    foreach ($tr as $node) {

                        if ($node->getAttribute('class') === 'even'){
                            $even = $node->nodeValue;


                            if (preg_match('/\vУдары\v/', $even))
                            {
                                $statistic = preg_split('/Удары/', $even);

                                $ud_h = (int) $statistic[0];

                                $ud_g = (int) $statistic[1];


                            }

                            if (preg_match('/Удары мимо/', $even))
                            {
                                $statistic = preg_split('/Удары мимо/', $even);

                                $ud_mim_h = (int) $statistic[0];

                                $ud_mim_g = (int)$statistic[1];


                            }

                            if (preg_match('/Офсайды/', $even))
                            {
                                $statistic = preg_split('/Офсайды/', $even);

                                $offside_h = (int) $statistic[0];

                                $offside_g = (int)$statistic[1];


                            }

                            if (preg_match('/Фолы/', $even))
                            {
                                $statistic = preg_split('/Фолы/', $even);

                                $falls_h = (int) $statistic[0];

                                $falls_g = (int)$statistic[1];


                            }

                            if (preg_match('/Удары в створ/', $even))
                            {
                                $statistic = preg_split('/Удары в створ/', $even);

                                $ud_v_stv_h = (int) $statistic[0];

                                $ud_v_stv_g = (int)$statistic[1];


                            }

                            if (preg_match('/Угловые/', $even))
                            {
                                $statistic = preg_split('/Угловые/', $even);

                                $corner_h = (int) $statistic[0];

                                $corner_g = (int)$statistic[1];


                            }

                            if (preg_match('/Сэйвы/', $even))
                            {
                                $statistic = preg_split('/Сэйвы/', $even);

                                $saves_h = (int) $statistic[0];

                                $saves_g = (int)$statistic[1];


                            }

                            if (preg_match('/Желтые карточки/', $even))
                            {
                                $statistic = preg_split('/Желтые карточки/', $even);

                                $yelkar_h = (int) $statistic[0];

                                $yelkar_g = (int)$statistic[1];


                            }
                            if (preg_match('/Владение мячом/', $even))
                            {
                                $statistic = preg_split('/Владение мячом/', $even);

                                $ballpos_h = (int) $statistic[0];

                                $ballpos_g = (int)$statistic[1];


                            }

                            if (preg_match('/Штрафные/', $even))
                            {
                                $statistic = preg_split('/Штрафные/', $even);

                                $shtraf_h = (int) $statistic[0];

                                $shtraf_g = (int)$statistic[1];

                            }

                            if (preg_match('/Вбрасывания/', $even))
                            {
                                $statistic = preg_split('/Вбрасывания/', $even);

                                $outs_h = (int) $statistic[0];

                                $outs_g = (int)$statistic[1];

                            }

                        }

                    }
                }


            }

            $table = $dom->getElementsByTagName("table");

            foreach ($table as $node) {

                if ($node->getAttribute('id') === 'parts') {
                    if (preg_match("/[0-9]{1} \- [0-9]{1} \- [0-9]{1} \- /", $node->nodeValue)) {

                        $stay = $node->nodeValue;
                        $sty = explode("Расстановка", $stay);
                        if(is_array($stay)) {
                            $stay_h = $sty[0];
                            $stay_g = $sty[1];
                        }


                    }
                }
            }

            $td = $dom->getElementsByTagName("td");

            foreach ($td as $node) {

                if ($node->getAttribute('class') === 'summary-vertical fl')
                {
                    $dt = $node->nodeValue;
                    $dom_in = new \DomDocument();
                    $html = $node->ownerDocument->saveHTML($node);
                    $newhtml = $head . $html;
                    $dom_in->loadHTML($newhtml);



                    $dv = $dom_in->getElementsByTagName("div");


                    foreach ($dv as $node) {

                        if ($node->getAttribute('class') === 'icon-box y-card'){


                            $yel_kart_h = $yel_kart_h . $dt . ", ";
                        }
                        if ($node->getAttribute('class') === 'icon-box r-card')
                            $red_kart_h = $red_kart_h.$dt. ", ";
                        if ($node->getAttribute('class') === 'icon-box yr-card')
                            $red_kart_h = $red_kart_h. $dt."(вторая жёлтая), ";
                        if ($node->getAttribute('class') === 'icon-box substitution-in')
                            $substit_h = $substit_h. $dt. ", ";
                        if ($node->getAttribute('class') === 'icon-box soccer-ball')
                            $goul_h =  $goul_h. $dt. ", ";
                        if ($node->getAttribute('class') === 'icon-box soccer-ball-own')
                            $goul_h =  $goul_h. $dt. ", ";
                        if ($node->getAttribute('class') === 'icon-box penalty-missed')
                            $pen_miss_h = $pen_miss_h. $dt. ", ";


                    }


                    $sp = $dom_in->getElementsByTagName("span");

                    foreach ($sp as $node) {

                        for($n = 0; $n < 250; $n++)  {
                            if ($node->getAttribute('class') === "flag fl_$n")
                            {$stra_h = $stra_h . $n . "-". $dt . ", "; 	}
                        }


                    }



                }

                if ($node->getAttribute('class') === 'summary-vertical fr') {
                    $dt = $node->nodeValue;
                    $dom_in = new \DomDocument();
                    $html = $node->ownerDocument->saveHTML($node);
                    $dom_in->loadHTML($html);
                    $dv = $dom_in->getElementsByTagName("div");


                    foreach ($dv as $node) {

                        if ($node->getAttribute('class') === 'icon-box y-card')
                        {
                            $yel_kart_g = $yel_kart_g. $dt.", "; 	}
                        if ($node->getAttribute('class') === 'icon-box r-card')
                            $red_kart_g = $red_kart_g. $dt.", ";
                        if ($node->getAttribute('class') === 'icon-box yr-card')
                            $red_kart_g = $red_kart_g. $dt."(вторая жёлтая), ";
                        if ($node->getAttribute('class') === 'icon-box substitution-in')
                            $substit_g = $substit_g. $dt.", ";
                        if ($node->getAttribute('class') === 'icon-box soccer-ball')
                            $goul_g = $goul_g. $dt.", ";
                        if ($node->getAttribute('class') === 'icon-box soccer-ball-own')
                            $goul_g = $goul_g. $dt.", ";
                        if ($node->getAttribute('class') === 'icon-box penalty-missed')
                            $pen_miss_g = $pen_miss_g .$dt.", ";

                    }

                    $sp = $dom_in->getElementsByTagName("span");

                    foreach ($sp as $node) {

                        for($n = 0; $n < 250; $n++)  {
                            if ($node->getAttribute('class') === "flag fl_$n")
                            {$stra_g = $stra_g . $n . "-". $dt . ", "; 	}
                        }


                    }
                }


                if ($node->getAttribute('class') === 'tname-home logo-enable')
                    $host = $node->nodeValue;
                if ($node->getAttribute('class') === 'tname-away logo-enable')
                    $guest = $node->nodeValue;
                if ($node->getAttribute('class') === 'current-result') {
                    $score = $node->nodeValue;
                    $sc = explode("-", $score);

                    $gett = (int) $sc[0];
                    $lett = (int) $sc[1];
                }

                if ($node->getAttribute('class') === 'mstat-date') {
                    $date_time = $node->nodeValue;
                    $dati = explode(" ", $date_time);

                    $date = $dati[0];
                    $time = $dati[1];
                }

                if ($node->getAttribute('class') === 'mstat') {
                    if ($node->nodeValue !== 'Завершен') $prim = $prim. " ". $node->nodeValue;
                }

                if ($node->getAttribute('class') === 'kx o_1')
                    $bet_h = (float) $node->nodeValue;
                if ($node->getAttribute('class') === 'kx o_0')
                    $bet_n = (float) $node->nodeValue;
                if ($node->getAttribute('class') === 'kx o_2')
                    $bet_g = (float) $node->nodeValue;
                if ($node->getAttribute('class') === 'kx o_1 winner')
                    $bet_h = (float) $node->nodeValue;
                if ($node->getAttribute('class') === 'kx o_0 winner')
                    $bet_n = (float) $node->nodeValue;
                if ($node->getAttribute('class') === 'kx o_2 winner')
                    $bet_g = (float) $node->nodeValue;


            }
            $span = $dom->getElementsByTagName("span");

            foreach ($span as $node) {
                if ($node->getAttribute('class') === 'info-bubble')
                    $prim = $prim = $prim. " ".$node->nodeValue;
                if ($node->getAttribute('class') === 'p1_home')
                    $onehalf_h = (int) $node->nodeValue;
                if ($node->getAttribute('class') === 'p1_away')
                    $onehalf_g = (int) $node->nodeValue;
            }

        /*
            if($host) $host = addslashes($host);
            if($yel_kart_h) $yel_kart_h = addslashes($yel_kart_h);
            if($red_kart_h) $red_kart_h = addslashes($red_kart_h);
            if($substit_h) $substit_h = addslashes($substit_h);
            if($goul_h) $goul_h = addslashes($goul_h);
            if($pen_miss_h) $pen_miss_h = addslashes($pen_miss_h);
            if($stra_h) $stra_h = addslashes($stra_h);

            if($guest) $guest = addslashes($guest);
            if($yel_kart_g) $yel_kart_g = addslashes($yel_kart_g);
            if($red_kart_g) $red_kart_g = addslashes($red_kart_g);
            if($substit_g) $substit_g = addslashes($substit_g);
            if($goul_g) $goul_g = addslashes($goul_g);
            if($pen_miss_g) $pen_miss_g = addslashes($pen_miss_g);
            if($stra_g) $stra_g = addslashes($stra_g);
        */

            if (isset($date) && ($tournament != '') && isset($host) && ($host != '')) {
                $match = new Matches();

                $match->date = $date;
                $match->time = $time;
                $match->tournament = $tournament;
                $match->host = $host;
                $match->guest = $guest;
                $match->gett = $gett;
                $match->lett = $lett;
                $match->stay_h = $stay_h;
                $match->stay_g = $stay_g;
                $match->yel_kart_h = $yel_kart_h;
                $match->yel_kart_g = $yel_kart_g;
                $match->red_kart_h = $red_kart_h;
                $match->red_kart_g = $red_kart_g;
                $match->substit_h = $substit_h;
                $match->substit_g = $substit_g;
                $match->goul_h = $goul_h;
                $match->goul_g = $goul_g;
                $match->pen_miss_h = $pen_miss_h;
                $match->pen_miss_g = $pen_miss_g;
                $match->onehalf_h = $onehalf_h;
                $match->onehalf_g = $onehalf_g;
                $match->prim = $prim;
                $match->stra_h = $stra_h;
                $match->stra_g = $stra_g;
                $match->ud_h = $ud_h;
                $match->ud_g = $ud_g;
                $match->ud_mim_h = $ud_mim_h;
                $match->ud_mim_g = $ud_mim_g;
                $match->offside_h = $offside_h;
                $match->offside_g = $offside_g;
                $match->falls_h = $falls_h;
                $match->falls_g = $falls_g;
                $match->ud_v_stv_h = $ud_v_stv_h;
                $match->ud_v_stv_g = $ud_v_stv_g;
                $match->corner_h = $corner_h;
                $match->corner_g = $corner_g;
                $match->saves_h = $saves_h;
                $match->saves_g = $saves_g;
                $match->yelkar_h = $yelkar_h;
                $match->yelkar_g = $yelkar_g;
                $match->ballpos_h = $ballpos_h;
                $match->ballpos_g = $ballpos_g;
                $match->shtraf_h = $shtraf_h;
                $match->shtraf_g = $shtraf_g;
                $match->outs_h = $outs_h;
                $match->outs_g = $outs_g;
                $match->bet_h = $bet_h;
                $match->bet_n = $bet_n;
                $match->bet_g = $bet_g;

                $match->save(false);

            }


           /*

                $result = Yii::app()->db->createCommand("INSERT INTO 'foo_matches'
(date, time, tournament, host, guest, gett, lett, stay_h, stay_g, yel_kart_h, red_kart_h, yel_kart_g,
           red_kart_g, substit_h, substit_g, goul_h, goul_g, pen_miss_h, pen_miss_g, onehalf_h, onehalf_g,
           prim, stra_h, stra_g, ud_h, ud_g, ud_mim_h, ud_mim_g, offside_h, offside_g,
           falls_h, falls_g, ud_v_stv_h, ud_v_stv_g, corner_h, corner_g, saves_h, saves_g,
           yelkar_h, yelkar_g, ballpos_h, ballpos_g, shtraf_h, shtraf_g, outs_h, outs_g, bet_h, bet_n, bet_g) VALUES ('$date', '$time','$tournament', '$host', '$guest', '$gett', '$lett', '$stay_h', '$stay_g', '$yel_kart_h', '$red_kart_h', '$yel_kart_g', '$red_kart_g', '$substit_h', '$substit_g', '$goul_h',  '$goul_g', '$pen_miss_h', '$pen_miss_g', '$onehalf_h', '$onehalf_g', '$prim', '$stra_h', '$stra_g', '$ud_h', '$ud_g', '$ud_mim_h', '$ud_mim_g', '$offside_h', '$offside_g', '$falls_h', '$falls_g', '$ud_v_stv_h', '$ud_v_stv_g', '$corner_h', '$corner_g', '$saves_h', '$saves_g', '$yelkar_h', '$yelkar_g', '$ballpos_h', '$ballpos_g', '$shtraf_h', '$shtraf_g', '$outs_h', '$outs_g', '$bet_h', '$bet_n', '$bet_g')");

*/
        }
    }
}
