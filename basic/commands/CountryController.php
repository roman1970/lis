<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Matches;
use app\models\Team;
use app\models\Totmatch;
use app\models\Totpredict;
use yii\console\Controller;
use app\components\DocxConverter;
use app\models\Country;
use app\models\Articles;
use Yii;
use yii\helpers\ArrayHelper;
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
            $info = '';


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

                if ($node->getAttribute('class') === 'parts match-information') {
                    $info = substr($node->nodeValue, 34);

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
                $match->info = $info;
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

    /**
     * Заполнение таблицы country данными
     * @throws \Exception
     */
    public function actionFillCountruWithSocCode() {

        $models = Country::find()->all();

        foreach($models as $model) {

            if($model->id == 2) {$model->iso_code = 'au'; $model->soc_abrev = '(Авс)'; $model->soccer_code = 24; $model->update();}
            if($model->id == 3) {$model->iso_code = 'at'; $model->soc_abrev = '(Авт)'; $model->soccer_code = 25; $model->update();}
            if($model->id == 4) {$model->iso_code = 'az'; $model->soc_abrev = '(Азе)'; $model->soccer_code = 26; $model->update();}
            if($model->id == 6) {$model->iso_code = 'al'; $model->soc_abrev = '(Алб)'; $model->soccer_code = 17; $model->update();}
            if($model->id == 7) {$model->iso_code = 'dz'; $model->soc_abrev = '(Алж)'; $model->soccer_code = 18; $model->update();}
            if($model->id == 10) {$model->iso_code = 'ao';  $model->soccer_code = 20; $model->update();}
            if($model->id == 11) {$model->iso_code = 'ad'; $model->soc_abrev = '(Анд)'; $model->soccer_code = 19; $model->update();}
            if($model->id == 12) {$model->iso_code = 'aq'; $model->soccer_code = 10; $model->update();}
            if($model->id == 13) {$model->iso_code = 'ag'; $model->soccer_code = 28; $model->update();}
            if($model->id == 14) {$model->iso_code = 'ar'; $model->soc_abrev = '(Арг)'; $model->soccer_code = 22; $model->update();}
            if($model->id == 15) {$model->iso_code = 'am'; $model->soc_abrev = '(Арм)'; $model->soccer_code = 19; $model->update();}
            if($model->id == 16) {$model->iso_code = 'aw';  $model->update();}
            if($model->id == 17) {$model->iso_code = 'af';  $model->update();}
            if($model->id == 18) {$model->iso_code = 'bs';  $model->update();}
            if($model->id == 20) {$model->iso_code = 'bd';  $model->update();}
            if($model->id == 21) {$model->iso_code = 'bb';  $model->update();}
            if($model->id == 22) {$model->iso_code = 'bh';  $model->update();}
            if($model->id == 23) {$model->iso_code = 'by';  $model->soc_abrev = '(Беи)'; $model->soccer_code = 31; $model->update();}
            if($model->id == 24) {$model->iso_code = 'bz';  $model->update();}
            if($model->id == 25) {$model->iso_code = 'be';  $model->soc_abrev = '(Бел)'; $model->soccer_code = 32; $model->update();}
            if($model->id == 26) {$model->iso_code = 'bj';  $model->update();}
            if($model->id == 27) {$model->iso_code = 'bm';  $model->update();}
            if($model->id == 28) {$model->iso_code = 'bg';  $model->soc_abrev = '(Бог)'; $model->soccer_code = 41; $model->update();}
            if($model->id == 29) {$model->iso_code = 'bo';  $model->soc_abrev = '(Бол)'; $model->soccer_code = 36; $model->update();}
            if($model->id == 30) {$model->iso_code = 'ba';  $model->soc_abrev = '(Бос)'; $model->soccer_code = 37; $model->update();}
            if($model->id == 31) {$model->iso_code = 'bw'; $model->update();}
            if($model->id == 32) {$model->iso_code = 'br';  $model->soc_abrev = '(Бра)'; $model->soccer_code = 39; $model->update();}
            if($model->id == 33) {$model->iso_code = 'io';  $model->update();}
            if($model->id == 34) {$model->iso_code = 'bn';  $model->update();}
            if($model->id == 35) {$model->iso_code = 'bf';  $model->update();}
            if($model->id == 36) {$model->iso_code = 'bi';  $model->update();}
            if($model->id == 37) {$model->iso_code = 'bt';  $model->update();}
            if($model->id == 38) {$model->iso_code = 'va';  $model->update();}
            if($model->id == 39) {$model->iso_code = 'gb';  $model->update();}
            if($model->id == 40) {$model->iso_code = 'hu';  $model->soc_abrev = '(Вен)'; $model->soccer_code = 91; $model->update();}
            if($model->id == 41) {$model->iso_code = 've';  $model->soccer_code = 205; $model->update();}
            if($model->id == 44) {$model->iso_code = 'vn';  $model->soc_abrev = '(Вье)';$model->soccer_code = 206; $model->update();}
            if($model->id == 45) {$model->iso_code = 'ga';  $model->soccer_code = 78; $model->update();}
            if($model->id == 46) {$model->iso_code = 'ht';  $model->update();}
            if($model->id == 47) {$model->iso_code = 'gy';  $model->update();}
            if($model->id == 48) {$model->iso_code = 'gm';  $model->soccer_code = 79; $model->update();}
            if($model->id == 49) {$model->iso_code = 'gh';  $model->soccer_code = 82; $model->update();}
            if($model->id == 50) {$model->iso_code = 'gp';  $model->update();}
            if($model->id == 51) {$model->iso_code = 'gt';  $model->soccer_code = 85; $model->update();}
            if($model->id == 52) {$model->iso_code = 'gn';  $model->soccer_code = 86; $model->update();}
            if($model->id == 53) {$model->iso_code = 'gw';  $model->update();}
            if($model->id == 54) {$model->iso_code = 'de';  $model->soc_abrev = '(Гер)';$model->soccer_code = 81; $model->update();}
            if($model->id == 55) {$model->iso_code = 'gi';  $model->soc_abrev = '(Гиб)';$model->soccer_code = 304; $model->update();}
            if($model->id == 56) {$model->iso_code = 'hn';  $model->soccer_code = 90; $model->update();}
            if($model->id == 57) {$model->iso_code = 'gd';  $model->update();}
            if($model->id == 58) {$model->iso_code = 'gl';  $model->update();}
            if($model->id == 59) {$model->iso_code = 'gr';  $model->soc_abrev = '(Гри)';$model->soccer_code = 83; $model->update();}
            if($model->id == 60) {$model->iso_code = 'ge';  $model->soc_abrev = '(Гру)';$model->soccer_code = 80; $model->update();}
            if($model->id == 61) {$model->iso_code = 'dk';  $model->soc_abrev = '(Дан)';$model->soccer_code = 63; $model->update();}
            if($model->id == 62) {$model->iso_code = 'cd';  $model->soccer_code = 56; $model->update();}
            if($model->id == 63) {$model->iso_code = 'dj';  $model->soccer_code = 64; $model->update();}
            if($model->id == 64) {$model->iso_code = 'dm';  $model->update();}
            if($model->id == 65) {$model->iso_code = 'co';  $model->update();}
            if($model->id == 66) {$model->iso_code = 'eg';  $model->soccer_code = 69; $model->update();}
            if($model->id == 67) {$model->iso_code = 'zm';  $model->soccer_code = 209; $model->update();}
            if($model->id == 68) {$model->iso_code = 'eh';  $model->update();}
            if($model->id == 69) {$model->iso_code = 'zw';  $model->soccer_code = 210; $model->update();}
            if($model->id == 70) {$model->iso_code = 'il';  $model->soc_abrev = '(Изр)';$model->soccer_code = 97; $model->update();}
            if($model->id == 71) {$model->iso_code = 'in';  $model->soccer_code = 93; $model->update();}
            if($model->id == 72) {$model->iso_code = 'id';  $model->soc_abrev = '(Ина)';$model->soccer_code = 228; $model->update();}
            if($model->id == 73) {$model->iso_code = 'jo';  $model->soccer_code = 101; $model->update();}
            if($model->id == 74) {$model->iso_code = 'iq';  $model->soccer_code = 95; $model->update();}
            if($model->id == 75) {$model->iso_code = 'ir';  $model->soc_abrev = '(Ирн)';$model->soccer_code = 94; $model->update();}
            if($model->id == 76) {$model->iso_code = 'ie';  $model->soc_abrev = '(Иря)';$model->soccer_code = 96; $model->update();}
            if($model->id == 77) {$model->iso_code = 'is';  $model->soc_abrev = '(Исл)';$model->soccer_code = 92; $model->update();}
            if($model->id == 78) {$model->iso_code = 'es';  $model->soc_abrev = '(Исп)';$model->soccer_code = 176; $model->update();}
            if($model->id == 79) {$model->iso_code = 'it';  $model->soc_abrev = '(Ита)';$model->soccer_code = 98; $model->update();}
            if($model->id == 80) {$model->iso_code = 'ye';  $model->soccer_code = 208; $model->update();}
            if($model->id == 81) {$model->iso_code = 'cv';  $model->soccer_code = 48; $model->update();}
            if($model->id == 82) {$model->iso_code = 'kz';  $model->soc_abrev = '(Каз)';$model->soccer_code = 102; $model->update();}
            if($model->id == 83) {$model->iso_code = 'ky';  $model->update();}
            if($model->id == 84) {$model->iso_code = 'kh';  $model->update();}
            if($model->id == 85) {$model->iso_code = 'cm';  $model->soc_abrev = '(Кам)';$model->soccer_code = 46; $model->update();}
            if($model->id == 86) {$model->iso_code = 'ca';  $model->soc_abrev = '(Кан)';$model->soccer_code = 47; $model->update();}
            if($model->id == 88) {$model->iso_code = 'qa';  $model->soc_abrev = '(Кат)';$model->soccer_code = 156; $model->update();}
            if($model->id == 89) {$model->iso_code = 'ke';  $model->soccer_code = 103; $model->update();}
            if($model->id == 90) {$model->iso_code = 'cy';  $model->soc_abrev = '(Кип)';$model->soccer_code = 61; $model->update();}
            if($model->id == 91) {$model->iso_code = 'kg';  $model->update();}
            if($model->id == 92) {$model->iso_code = 'ki';  $model->update();}
            if($model->id == 93) {$model->iso_code = 'cn';  $model->soc_abrev = '(Кит)';$model->soccer_code = 52; $model->update();}
            if($model->id == 94) {$model->iso_code = 'cc';  $model->update();}
            if($model->id == 95) {$model->iso_code = 'co';  $model->soc_abrev = '(Кол)';$model->soccer_code = 53; $model->update();}
            if($model->id == 96) {$model->iso_code = 'km';  $model->update();}
            if($model->id == 97) {$model->iso_code = 'cr';  $model->soccer_code = 57; $model->update();}
            if($model->id == 98) {$model->iso_code = 'ci';  $model->soc_abrev = '(Кот)';$model->soccer_code = 58; $model->update();}
            if($model->id == 99) {$model->iso_code = 'cu';  $model->update();}
            if($model->id == 100) {$model->iso_code = 'kw';  $model->soccer_code = 107; $model->update();}
            if($model->id == 101) {$model->iso_code = 'kw';  $model->update();}
            if($model->id == 102) {$model->iso_code = 'lv';  $model->soccer_code = 110; $model->update();}
            if($model->id == 103) {$model->iso_code = 'ls';  $model->soccer_code = 112; $model->update();}
            if($model->id == 104) {$model->iso_code = 'lr';  $model->soccer_code = 113; $model->update();}
            if($model->id == 105) {$model->iso_code = 'ly';  $model->update();}
            if($model->id == 106) {$model->soccer_code = 114; $model->update();}
            if($model->id == 107) {$model->iso_code = 'lt'; $model->soc_abrev = '(Лит)'; $model->soccer_code = 116; $model->update();}
            if($model->id == 108) {$model->iso_code = 'li'; $model->soc_abrev = '(Лих)'; $model->soccer_code = 115; $model->update();}
            if($model->id == 109) {$model->iso_code = 'lu'; $model->soc_abrev = '(Люк)'; $model->soccer_code = 117; $model->update();}
            if($model->id == 110) {$model->iso_code = 'mu'; $model->soccer_code = 127; $model->update();}
            if($model->id == 111) {$model->iso_code = 'mr'; $model->soccer_code = 126; $model->update();}
            if($model->id == 112) {$model->iso_code = 'mg'; $model->update();}
            if($model->id == 113) {$model->iso_code = 'yt'; $model->update();}
            if($model->id == 114) {$model->iso_code = 'lt'; $model->soc_abrev = '(Мад)'; $model->soccer_code = 118; $model->update();}
            if($model->id == 115) {$model->iso_code = 'mw'; $model->soccer_code = 120; $model->update();}
            if($model->id == 116) {$model->iso_code = 'my'; $model->soc_abrev = '(Маз)'; $model->soccer_code = 121; $model->update();}
            if($model->id == 117) {$model->iso_code = 'ml'; $model->soccer_code = 123; $model->update();}
            if($model->id == 118) {$model->iso_code = 'mv'; $model->update();}
            if($model->id == 119) {$model->iso_code = 'mt'; $model->soc_abrev = '(Млт)'; $model->soccer_code = 124; $model->update();}
            if($model->id == 120) {$model->iso_code = 'ma'; $model->soc_abrev = '(Мар)'; $model->soccer_code = 134; $model->update();}
            if($model->id == 121) {$model->iso_code = 'mh'; $model->update();}
            if($model->id == 122) {$model->iso_code = 'mx'; $model->soc_abrev = '(Мек)'; $model->soccer_code = 128; $model->update();}
            if($model->id == 124) {$model->iso_code = 'fm'; $model->update();}
            if($model->id == 125) {$model->iso_code = 'mz'; $model->soccer_code = 135; $model->update();}
            if($model->id == 126) {$model->iso_code = 'md'; $model->soc_abrev = '(Мол)'; $model->soccer_code = 130; $model->update();}
            if($model->id == 127) {$model->iso_code = 'mc'; $model->update();}
            if($model->id == 128) {$model->iso_code = 'mn'; $model->update();}
            if($model->id == 129) {$model->iso_code = 'ms'; $model->update();}
            if($model->id == 130) {$model->iso_code = 'mm'; $model->update();}
            if($model->id == 131) {$model->iso_code = 'na'; $model->soccer_code = 136; $model->update();}
            if($model->id == 132) {$model->iso_code = 'nr'; $model->update();}
            if($model->id == 133) {$model->iso_code = 'np'; $model->update();}
            if($model->id == 134) {$model->iso_code = 'ne'; $model->soccer_code = 142; $model->update();}
            if($model->id == 135) {$model->iso_code = 'ng'; $model->soccer_code = 143; $model->update();}
            if($model->id == 136) {$model->iso_code = 'an'; $model->update();}
            if($model->id == 137) {$model->iso_code = 'nl'; $model->soc_abrev = '(Нид)'; $model->soccer_code = 139; $model->update();}
            if($model->id == 138) {$model->iso_code = 'ni'; $model->update();}
            if($model->id == 139) {$model->iso_code = 'nz'; $model->soc_abrev = '(Нзл)'; $model->soccer_code = 140; $model->update();}
            if($model->id == 140) {$model->iso_code = 'nc'; $model->update();}
            if($model->id == 141) {$model->iso_code = 'no'; $model->soc_abrev = '(Нор)'; $model->soccer_code = 145; $model->update();}
            if($model->id == 142) {$model->iso_code = 'nf'; $model->update();}
            if($model->id == 143) {$model->iso_code = 'ae'; $model->soc_abrev = '(ОАЭ)'; $model->soccer_code = 196; $model->update();}
            if($model->id == 144) {$model->iso_code = 'om'; $model->update();}
            if($model->id == 145) {$model->iso_code = 'gu'; $model->update();}
            if($model->id == 150) {$model->iso_code = 'pk'; $model->soccer_code = 147; $model->update();}
            if($model->id == 151) {$model->iso_code = 'pw'; $model->update();}
            if($model->id == 153) {$model->iso_code = 'pa'; $model->soc_abrev = '(Пан)';$model->soccer_code = 149; $model->update();}
            if($model->id == 154) {$model->iso_code = 'pg'; $model->update();}
            if($model->id == 155) {$model->iso_code = 'py'; $model->soc_abrev = '(Пар)';$model->soccer_code = 151; $model->update();}
            if($model->id == 156) {$model->iso_code = 'pe'; $model->soc_abrev = '(Пер)';$model->soccer_code = 152; $model->update();}
            if($model->id == 157) {$model->iso_code = 'pl'; $model->soc_abrev = '(Пол)';$model->soccer_code = 154; $model->update();}
            if($model->id == 158) {$model->iso_code = 'pt'; $model->soc_abrev = '(Пор)';$model->soccer_code = 155; $model->update();}
            if($model->id == 159) {$model->iso_code = 'vu'; $model->update();}
            if($model->id == 160) {$model->iso_code = 'cd'; $model->update();}
            if($model->id == 161) {$model->iso_code = 're'; $model->update();}
            if($model->id == 162) {$model->iso_code = 'ru'; $model->soc_abrev = '(Рос)';$model->soccer_code = 158; $model->update();}
            if($model->id == 163) {$model->iso_code = 'rw'; $model->soccer_code = 159; $model->update();}
            if($model->id == 164) {$model->iso_code = 'ro'; $model->soc_abrev = '(Рум)';$model->soccer_code = 157; $model->update();}
            if($model->id == 165) {$model->iso_code = 'us'; $model->soc_abrev = '(США)';$model->soccer_code = 200; $model->update();}
            if($model->id == 166) {$model->iso_code = 'sv'; $model->soccer_code = 70; $model->update();}
            if($model->id == 167) {$model->iso_code = 'ws'; $model->update();}
            if($model->id == 168) {$model->iso_code = 'sm'; $model->soc_abrev = '(Сан)';$model->soccer_code = 163; $model->update();}
            if($model->id == 169) {$model->iso_code = 'st'; $model->update();}
            if($model->id == 170) {$model->iso_code = 'sa'; $model->soc_abrev = '(Сау)';$model->soccer_code = 165; $model->update();}
            if($model->id == 171) {$model->soccer_code = 180; $model->update();}
            if($model->id == 172) {$model->iso_code = 'kp';  $model->update();}
            if($model->id == 173) {$model->iso_code = 'mp'; $model->update();}
            if($model->id == 174) {$model->iso_code = 'sc'; $model->update();}
            if($model->id == 175) {$model->iso_code = 'sn'; $model->soccer_code = 166; $model->update();}
            if($model->id == 176) {$model->iso_code = 'vc'; $model->update();}
            if($model->id == 177) {$model->iso_code = 'kn'; $model->update();}
            if($model->id == 178) {$model->iso_code = 'lc'; $model->update();}
            if($model->id == 179) {$model->iso_code = 'rs'; $model->soc_abrev = '(Сер)';$model->soccer_code = 167; $model->update();}
            if($model->id == 181) {$model->iso_code = 'sg'; $model->soc_abrev = '(Син)';$model->soccer_code = 170; $model->update();}
            if($model->id == 182) {$model->iso_code = 'sy'; $model->soccer_code = 183; $model->update();}
            if($model->id == 183) {$model->iso_code = 'sk'; $model->soc_abrev = '(Сла)'; $model->soccer_code = 171; $model->update();}
            if($model->id == 184) {$model->iso_code = 'si'; $model->soc_abrev = '(Сло)'; $model->soccer_code = 172; $model->update();}
            if($model->id == 185) {$model->iso_code = 'sb'; $model->update();}
            if($model->id == 186) {$model->iso_code = 'so'; $model->update();}
            if($model->id == 187) {$model->iso_code = 'sd'; $model->soccer_code = 178; $model->update();}
            if($model->id == 188) {$model->iso_code = 'sr'; $model->update();}
            if($model->id == 189) {$model->iso_code = 'sl'; $model->soccer_code = 169; $model->update();}
            if($model->id == 190) {$model->iso_code = 'tj'; $model->soccer_code = 184; $model->update();}
            if($model->id == 191) {$model->iso_code = 'th'; $model->soc_abrev = '(Таи)'; $model->soccer_code = 186; $model->update();}
            if($model->id == 192) {$model->iso_code = 'tw'; $model->update();}
            if($model->id == 193) {$model->iso_code = 'tz'; $model->soccer_code = 185; $model->update();}
            if($model->id == 194) {$model->iso_code = 'tg'; $model->soccer_code = 187; $model->update();}
            if($model->id == 195) {$model->iso_code = 'to'; $model->update();}
            if($model->id == 196) {$model->iso_code = 'tt'; $model->update();}
            if($model->id == 197) {$model->iso_code = 'tv'; $model->update();}
            if($model->id == 198) {$model->iso_code = 'tn'; $model->soc_abrev = '(Тун)'; $model->soccer_code = 190; $model->update();}
            if($model->id == 199) {$model->iso_code = 'tm'; $model->update();}
            if($model->id == 200) {$model->iso_code = 'tr'; $model->soc_abrev = '(Туц)'; $model->soccer_code = 191; $model->update();}
            if($model->id == 201) {$model->iso_code = 'tc'; $model->update();}
            if($model->id == 202) {$model->iso_code = 'ug'; $model->soccer_code = 194; $model->update();}
            if($model->id == 203) {$model->iso_code = 'uz'; $model->soc_abrev = '(Узб)'; $model->soccer_code = 202; $model->update();}
            if($model->id == 204) {$model->iso_code = 'ua'; $model->soc_abrev = '(Укр)'; $model->soccer_code = 195; $model->update();}
            if($model->id == 205) {$model->iso_code = 'uy'; $model->soc_abrev = '(Уру)'; $model->soccer_code = 201; $model->update();}
            if($model->id == 206) {$model->iso_code = 'fo'; $model->soc_abrev = '(Фар)'; $model->soccer_code = 231; $model->update();}
            if($model->id == 207) {$model->iso_code = 'fj'; $model->update();}
            if($model->id == 208) {$model->iso_code = 'ph'; $model->soccer_code = 153; $model->update();}
            if($model->id == 209) {$model->iso_code = 'fi'; $model->soc_abrev = '(Фин)'; $model->soccer_code = 76; $model->update();}
            if($model->id == 210) {$model->iso_code = 'fr'; $model->soc_abrev = '(Фра)'; $model->soccer_code = 77; $model->update();}
            if($model->id == 211) {$model->iso_code = 'gf'; $model->update();}
            if($model->id == 212) {$model->iso_code = 'pf'; $model->update();}
            if($model->id == 213) {$model->iso_code = 'hr'; $model->soc_abrev = '(Хор)'; $model->soccer_code = 59; $model->update();}
            if($model->id == 214) {$model->iso_code = 'cf'; $model->update();}
            if($model->id == 215) {$model->iso_code = 'td'; $model->update();}
            if($model->id == 216) {$model->iso_code = 'me'; $model->soc_abrev = '(Чрн)'; $model->soccer_code = 133; $model->update();}
            if($model->id == 217) {$model->iso_code = 'cz'; $model->soc_abrev = '(Чех)'; $model->soccer_code = 62; $model->update();}
            if($model->id == 218) {$model->iso_code = 'cl'; $model->soc_abrev = '(Чил)'; $model->soccer_code = 51; $model->update();}
            if($model->id == 219) {$model->iso_code = 'ch'; $model->soc_abrev = '(Шва)'; $model->soccer_code = 182; $model->update();}
            if($model->id == 220) {$model->iso_code = 'se'; $model->soc_abrev = '(Шве)'; $model->soccer_code = 181; $model->update();}
            if($model->id == 221) {$model->iso_code = 'lk'; $model->update();}
            if($model->id == 222) {$model->iso_code = 'ec'; $model->soc_abrev = '(Эка)'; $model->soccer_code = 68; $model->update();}
            if($model->id == 223) {$model->iso_code = 'gq'; $model->update();}
            if($model->id == 224) {$model->iso_code = 'er'; $model->update();}
            if($model->id == 225) {$model->iso_code = 'ee'; $model->soc_abrev = '(Эст)'; $model->soccer_code = 73; $model->update();}
            if($model->id == 226) {$model->iso_code = 'et'; $model->soccer_code = 74; $model->update();}
            if($model->id == 227) {$model->iso_code = 'za'; $model->soc_abrev = '(Южн)'; $model->soccer_code = 175; $model->update();}
            if($model->id == 228) {$model->iso_code = 'kr'; $model->soc_abrev = '(Кор)'; $model->soccer_code = 106; $model->update();}
            if($model->id == 230) {$model->iso_code = 'jm'; $model->soc_abrev = '(Ямк)'; $model->update();}
            if($model->id == 231) {$model->iso_code = 'jp'; $model->soc_abrev = '(Япо)'; $model->soccer_code = 100; $model->update();}
            if($model->id == 232) {$model->iso_code = 'gb'; $model->soc_abrev = '(Уэл)'; $model->soccer_code = 207; $model->update();}
            if($model->id == 233) {$model->iso_code = 'gb'; $model->soc_abrev = '(Анг)'; $model->soccer_code = 198; $model->update();}
            if($model->id == 234) {$model->iso_code = 'gb'; $model->soc_abrev = '(СИр)'; $model->soccer_code = 144; $model->update();}
            if($model->id == 235) {$model->iso_code = 'gb'; $model->soc_abrev = '(Шот)'; $model->soccer_code = 199; $model->update();}


        }
    }

    /**
     * Проверка прогнозов
     * @throws \Exception
     */
    public function actionMarkPredictedMatches(){
        $predicted = Totmatch::find()->where(['foo_match_id' => 1])->all();

        //var_dump($predicted); exit;

        foreach ($predicted as $match){
            $date = explode(" ", $match->date);
            try {
                $d = $date[0];
            } catch (\ErrorException $e) {
                $d = '';
            }
            $m = Matches::find()
                ->where("host like('_".$match->host."') and guest like('".$match->guest."_') and date like('".$d."')")
                ->one();
            if($m) {
                $match->foo_match_id = $m->id;
                $match->update();
            }
            else break;
            $tested = Totpredict::find()->where(['match_id' => $match->id])->all();
            foreach ($tested as $play){

                //var_dump($play->host_g);
                //var_dump($m->gett);
                //var_dump($play->guest_g);
                //var_dump($m->lett);
                if($play->host_g == $m->gett && $play->guest_g == $m->lett && ($m->prim !== ' После серии пенальти' &&
                        $m->prim !== ' После дополнительного времени')) {
                    $play->status = Totpredict::STATUS_RIGHT_SCORE;
                    $play->bet_balance = $this->getMatchBet($m->gett, $m->lett, $m->bet_h, $m->bet_n, $m->bet_g);
                    $play->update();
                }
                elseif($play->host_g == $play->guest_g && ($m->lett == $play->host_g || $m->gett == $play->guest_g ) &&
                    ($m->prim == ' После серии пенальти' ||  $m->prim == ' После дополнительного времени')){
                    var_dump($play);
                    $play->status = Totpredict::STATUS_RIGHT_SCORE;
                    $play->bet_balance = $this->getMatchBet(1, 1, $m->bet_h, $m->bet_n, $m->bet_g);
                    $play->update();
                }
                elseif($play->host_g == $play->guest_g && ($m->prim == ' После серии пенальти' ||
                        $m->prim == ' После дополнительного времени')){
                   var_dump($play);
                    $play->status = Totpredict::STATUS_RIGHT_RESULT;
                    $play->bet_balance = $this->getMatchBet(1, 1, $m->bet_h, $m->bet_n, $m->bet_g);
                    $play->update();
                }
                elseif($play->host_g <> $play->guest_g && ($m->prim == ' После серии пенальти' ||
                        $m->prim == ' После дополнительного времени')) {
                    var_dump($play);
                    $play->status = Totpredict::STATUS_BAD_PROGNOSE;
                    $play->bet_balance = -1;
                    $play->update();
                }
                elseif(($play->host_g > $play->guest_g && $m->gett > $m->lett) ||
                    ($play->host_g == $play->guest_g && $m->gett == $m->lett) ||
                    ($play->host_g < $play->guest_g && $m->gett < $m->lett)
                ) {
                    $play->status = Totpredict::STATUS_RIGHT_RESULT;
                    $play->bet_balance = $this->getMatchBet($m->gett, $m->lett, $m->bet_h, $m->bet_n, $m->bet_g);
                    $play->update();
                }
                else {
                    $play->status = Totpredict::STATUS_BAD_PROGNOSE;
                    $play->bet_balance = -1;
                    $play->update();
                }

            }
        }

    }

    /**
     * Заполнение таблицы команд
     */
    public function actionFillFTeams(){
       $m = Matches::find()
            ->select(['host, tournament, COUNT(*) as cnt'])
            ->groupBy('host')
            ->all();

        foreach ($m as $h){


            $team = new Team();
            $tournament = explode(':', $h->tournament);

            $team->name = iconv_substr($h->host, 1 , 80 , 'UTF-8' );
            if(strripos($team->name, '(')) {
                $host = explode(' ', $team->name);
                array_pop($host);
                $team->adapt_name = trim(implode(' ',$host));
            }
            $team->reg = isset($tournament[0]) ? $tournament[0] : '';
            $team->save(false);
        }
        //var_dump($m);
    }

    public function getMatchBet($host_g, $guest_g, $bet_h, $bet_n, $bet_g){
        if($bet_h != 0 && $bet_n != 0 && $bet_g != 0) {
            if($host_g > $guest_g) {
                return $bet_h - 1;
            }
            elseif($host_g == $guest_g) {
                return $bet_n - 1;
            }
            else
                return $bet_g - 1;
            }
        else return 0;
        }
    
    public function actionDumpOneDataMatches(){
        /*$m = Matches::find()
            ->where("date like '02.07.2016'")
            ->all();
        */
       $m =  mt_rand(0,3);
        echo $m;

    }

    /**
     * Проверка таблицы базы данных
     * @param $class
     * @param $column
     */
    public function actionTestUnicValTable($class, $column){

        $records = $class::find()
            ->select(["$column, COUNT($column) as cnt"])
            ->where('id > 70000')
            ->groupBy($column)
            ->all();

        foreach ($records as $rec){
            echo $rec['cnt'] ." - ". $rec['date'] . PHP_EOL;
        }


        
    }

}
