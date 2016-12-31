<?php
namespace app\commands;


use app\models\Articles;
use app\models\ArticlesContent;
use app\models\Author;
use app\models\Bought;
use app\models\Currencies;
use app\models\CurrHistory;
use app\models\DiaryActs;
use app\models\DiaryAte;
use app\models\DiaryDeals;
use app\models\DiaryDoneDeal;
use app\models\DiaryRecDayParams;
use app\models\Event;
use app\models\Incomes;
use app\models\Items;
use app\models\PogodaXXI;
use app\models\Snapshot;
use app\models\SongText;
use app\models\Source;
use app\models\Tag;
use app\models\Tasked;
use app\models\TeamSum;
use app\models\Telbase;
use app\models\Totmatch;
use app\modules\diary\models\Ormon;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Yii;
use app\components\Helper;
use app\components\TranslateHelper;
use yii\sphinx\Query;
use yii\sphinx\MatchExpression;


class ParsersController extends Controller
{
    public $arr = [];
    public $songs;
    public $tournament = '';
    public static $str = '';
    public static $header = "<head>
        <meta charset='utf-8'>
        <title>Тэги</title>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta name='description' content=''>
        <meta name='keywords' content=''>
        <meta name='author' content=''>

        <!--[if lt IE 9]>
        <script src='../html5shim.googlecode.com/svn/trunk/html5.js' tppabs='http://html5shim.googlecode.com/svn/trunk/html5.js'></script>
        <![endif]-->
        <!-- Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,100italic,100,400italic,500,500italic,700,700italic,900,900italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

        <!-- Stylesheets -->
        <link href='css/normalize.min.css' rel='stylesheet'>
        <link href='css/style.css' rel='stylesheet'>
        <link rel='stylesheet' type='text/css' href='css/bootstrap.min.css'>

        <style>
            .letters{
                font-weight: bold;
                border: 4px double black;
                width: 100%;
                text-align: center;
            }

        </style>

    </head><body> 
        <header>
            <div class='container'>

            </div>
        </header>


            <div class='container'>";

    public static $footer = "</div></body></html>";

    public function actionIndex()
    {
        $methods = get_class_methods($this);
        echo 'Actions:' . "\r\n";
        foreach ($methods as $method)
            if (preg_match('/^action(.+)$/', $method, $match))
                echo ' - ' . $match[1] . "\r\n";
    }


    public function actionSoccerstand($match_code=''){
        
        $arr_date = [];
        $tournament = [];

        $day_data = $this->_soccerStandCurl("http://d.soccerstand.com/ru/x/feed/f_1_-2_7_ru_1");

        $countries = explode(':',preg_replace("/[^-A-Za-z0-9а-ярьтцхчшуыйёА-ЯЁ.,!?:()№ ]+/", "", $day_data));

       //print_r($countries); exit;

        $i=0;

        $tournament = [];

        foreach ($countries as $country) {
            if($i==19) {
                $matchs = explode('AB÷3¬CR÷3¬AC÷3¬', $country);
                //var_dump($matchs);
                //exit;

                $n=0;
                foreach ($matchs as $match) {

                        $recs = explode('¬', $match);
                        //print_r($recs); exit;

                        foreach ($recs as $rec){
                            $arr_loc[$i][$n] = explode('÷', $rec);
                            if(is_array($arr_loc[$i])) {
                                //print_r($arr_loc[$i]);
                                if(isset($arr_loc[$i][$n][1]))
                                    $tournament[$i][$n][$arr_loc[$i][$n][0]] = $arr_loc[$i][$n][1];
                            }
                            else{
                                $n++; continue;
                            }

                        }
                    $n++;
                   // echo $n.PHP_EOL;
                }
            }



            //$tournament[$i]['matches'][] = explode('3¬÷3¬÷3', $country);
            /*
             * AB÷3¬CR÷3¬AC÷3¬

            $matches = explode('3¬÷3¬÷3', $country);

            foreach ($matches as $match){
               // preg_match_all("/([0-9]{10})¬/", $country, $tournament[$i]['match'][]);
                $tournament[$i]['match'][] = explode('¬÷', $match);
            }
            */
            $i++;

        }
      // exit;


       var_dump($tournament); exit;

        $output = [];

        //preg_match_all('/AA÷([0-9A-Za-z]{8})¬AD/', $day_data, $output);

       //var_dump(substr($output[0][1], 4, 8)); exit;

        $i=0;

        $handle = fopen(Url::to("@app/commands/soccertest.html"), "w");

        //foreach ($output[0] as $match_code) {
         //   if($i==3) return;
        //    $i++;

            $urls = [
                     "http://d.soccerstand.com/ru/x/feed/d_su_".$tournament[19][3]['AA']."_ru_1",
                     "http://d.soccerstand.com/ru/x/feed/d_st_".$tournament[19][3]['AA']."_ru_1",
                     "http://d.soccerstand.com/ru/x/feed/d_li_".$tournament[19][3]['AA']."_ru_1"
            ];

           foreach ($urls as $url) {

               $data = $this->_soccerStandCurl($url);
               fwrite($handle,  $data);
           }



        //}
        fclose($handle);



    }


    private function _soccerStandCurl($url){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвратить то что вернул сервер
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            [
                //'Accept-Encoding:gzip, deflate, sdch',
                //'Accept-Language:*',
                'Cache-Control:no-cache',
                'Connection:keep-alive',
                'Cookie:_dc_gtm_UA-28208502-12=1; _ga=GA1.2.1191596796.1477908016',
                'Host:d.soccerstand.com', 'Pragma:no-cache',
                'Referer:http://d.soccerstand.com/ru/x/feed/proxy-local',
                'User-Agent:Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36',
                'X-Fsign:SW9D1eZo',
                'X-GeoIP:1',
                'X-Requested-With:XMLHttpRequest',
                'Accept-Charset: Windows-1251,utf-8;q=0.7,*;q=0.7'
            ]);

        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
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

        $content = $this->get_page($url);
        //echo $content; exit;
        //$content = file_get_contents($url);
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

                for ($i = 1; $i <= 16; $i++) {

                    $url = "http://www.sport-express.ru/newspaper/$date/$j" . "_$i/?view=page";

                    try {
                        $content = $this->get_page($url);;
                    } catch (\ErrorException $e) {
                        break;
                    }

                    //$tag_in = '<div class="art_item">';
                    $tag_in = 'article_text publication blackcolor mt_30';
                    $tag_out = '<div class="se2_paginator">';



                    //отрезка нужного куска сайта
                    try {
                        $position = strpos($content, $tag_in, strlen($tag_in));
                    } catch (\ErrorException $e) {
                        continue;
                    }
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
                    */

                    $allowedTags='<a><br><b><h1><h2><h3><h4><i>' .
                        '<img><li><ol><p><strong><table>' .
                        '<tr><td><th><u><ul>';
                    $content = strip_tags($content, $allowedTags);



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
        $this->directory_tree("/home/romanych/se");
        fwrite($f_tree, self::$str);
        fclose($f_tree);



    }
    /**
     * Генератор тэговых страниц
     */
    public function actionGetTags(){

        $list = scandir('/home/romanych/www/vrs/pages/');
        $list = array_diff($list, ['.', '..']);
        //var_dump($list); exit;

        $alphabet = fopen("/home/romanych/www/vrs/alphabet.html", "w");
        fwrite($alphabet, self::$header);

        foreach($list as $letter) {
            fwrite($alphabet, "<div class='letters'><a href='pages/".$letter."/tags.html'>".$letter."</a></div>");
            $alfa_tags = fopen("/home/romanych/www/vrs/pages/".$letter."/tags.html", "w");
            fwrite($alfa_tags, self::$header);
            fwrite($alfa_tags, self::$footer);
            fclose($alfa_tags);

        }

        fwrite($alphabet, self::$footer);
        fclose($alphabet);


        $tags = Tag::find()
            ->orderBy('name')
            ->all();
        //var_dump($tags); exit;



        //$file =  fopen("/home/romanych/www/vrs/tags.html", "w");

        //fwrite($file, self::$header);

        foreach ($tags as $tag){

            $first_letter = mb_substr($tag->name,0,1,'UTF-8');
            //var_dump($first_letter); exit;

            $big_first_letter = mb_strtoupper($first_letter, 'UTF-8');


            $alfa_tags = fopen("/home/romanych/www/vrs/pages/".$big_first_letter."/tags.html", "a");

            fwrite($alfa_tags, "<a href='". TranslateHelper::translit($tag->name) .".html'><button type='button' class='btn btn-default btn-lg'>$tag->name</button></a>");
            fwrite($alfa_tags, self::$footer);
            fclose($alfa_tags);

            //fwrite($file, "<p><a href='pages/".$big_first_letter."/". TranslateHelper::translit($tag->name) .".html'>$tag->name</a></p>");

            $page = fopen("/home/romanych/www/vrs/pages/".$big_first_letter."/". TranslateHelper::translit($tag->name) .".html", "w");
            fwrite($page, '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                            <link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <style>.item_head{font-weight: bold;} body{padding-left: 20px; padding-top: 20px;} </style>');
            $items = explode(",", $tag->items);
            $r=1;
            foreach($items as $item) {

                try {
                    $item = Items::findOne(['id' => (int)$item]);
                    $source = Source::findOne(['id' => $item->source_id]);
                    $author = Author::findOne(['id' => $source->author_id]);
                    fwrite($page, "<p class='item_head'>$r $item->title ($author->name - $source->title)</p>
                    ".$this->renderPlayer($item->audio_link)."
                    ".nl2br("<p>$item->text</p>")."

                    ");
                } catch (\ErrorException $e) {
                    echo  $e->getMessage().PHP_EOL;
                    var_dump(Items::findOne(['id' => (int)$item]));
                }
            $r++;

            }
            fwrite($page, self::$footer);
            fclose($page);

        }
        //fwrite($file, self::$footer);
        //fclose($file);
    }

    /**
     * Генератор дневника знаний
     */
    public function actionDiaryGenerator(){
        $arr = [];
        $arr['ate_sum_kkal'] = 0;
        $article_time = '00:00';
        $start_day = strtotime('now 00:00:00');
        $today = date('Ymd', $start_day);
        //$today = '20161011_01';
        //echo $today.PHP_EOL; exit;
        
        $today_acts = DiaryActs::find()
            ->where("time > $start_day and user_id = 8")
            ->all();

        //var_dump($today_acts); exit;

        $f = 0;

        foreach  ($today_acts as $act ){
            switch ($act->model_id) {
                case 1:
                    if(DiaryAte::find()->where(['act_id' => $act->id])->one())
                        $arr['ate'][$act->time] = DiaryAte::find()->where(['act_id' => $act->id])->one();
                    $arr['ate_sum_kkal'] += DiaryAte::find()->where(['act_id' => $act->id])->one()->kkal;
                    break;
                case 2:
                    $arr['tasked'][$act->time] = Tasked::find()->where(['act_id' => $act->id])->one();
                    break;
                case 3:
                    $arr['bought'][$act->time] = Bought::find()->where(['act_id' => $act->id])->one();
                    break;
                case 4:
                    $arr['day_params'][$act->time] = DiaryRecDayParams::find()->where(['act_id' => $act->id])->one();
                    break;
                case 5:
                    $arr['deals'][$act->time] = DiaryDoneDeal::find()->where(['act_id' => $act->id])->one();
                    break;
                case 6:
                    if(Articles::find()->where(['act_id' => $act->id])->one()) {
                        if($f == 0) { echo $f." ".$today.PHP_EOL;
                            $articles = ArticlesContent::find()->where(['articles_id' => Articles::find()->where(['act_id' => $act->id])->one()->id])->all();
                            //var_dump($articles); exit;
                            //$article_time = $act->time;
                            $arr['article_title'] = Articles::find()->where(['act_id' => $act->id])->one()->title;
                            $f = 1;
                        }

                    }

                    break;
                case 7:
                    if(Items::find()->where(['act_id' => $act->id])->one()) {
                        $arr['items'][$act->time] = Items::find()->where(['act_id' => $act->id])->one();
                    }
                    break;
                case 9:
                    if(Incomes::find()->where(['act_id' => $act->id])->one()){
                        $arr['incomes'][$act->time] = Incomes::find()->where(['act_id' => $act->id])->one();
                    }
                    break;
                case 10:
                    if(Event::find()->where(['act_id' => $act->id])->one()){
                        $arr['events'][$act->time] = Event::find()->where(['act_id' => $act->id])->one();
                    }
                    break;
            }
        }
        $ate_sum_kkal = $arr['ate_sum_kkal'];

        //print_r($arr['articles']); var_dump($articles); exit;

        $file = fopen("/home/romanych/www/vrs/diary/2016/$today.html", "w");
        
        //хэдер
        fwrite($file, '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                            <link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <style>.item_head{font-weight: bold;} 
                                    body{padding-left: 20px; padding-top: 20px; background-color: rgba(78, 82, 65, 0.11);}
                                    img {width: 100%;min-height: 100px;}
                                    h3,h4,h5 {color: #994b43; text-align: left; margin-top: 1px; margin-bottom: 5px;}
                                    .mini{font-size: 10px; margin: 0; }
                                    .image img{width: auto;}
                            </style>
                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                            ');
        if(isset($arr['article_title'])){
            fwrite($file, "<hr><h3>".date('d-m-Y', $start_day)." ".$arr['article_title']."</h3><div class=\"btn-group\">
            <button type=\"button\" class=\"btn btn-default\"><span class=\"glyphicon glyphicon-star\"></button>
            
          </div>                <script>
                                  $('.mw-editsection-visualeditor').hide();
                                </script>");
        }


        /*блок еды
       if(isset($arr['ate'])){ fwrite($file, "<p>Съел $ate_sum_kkal kkal</p> 
               <table class='table'>
               <tbody>
                   <tr >
                       <td>м</td>
                       <td>блюдо</td>
                       <td>кол-во</td>
                       <td>ккал</td>
                     
                   </tr>");
           foreach ($arr['ate'] as $key => $ate){
               $dish = $ate->dish->name;
               $time = date('H:i',$key+7*3600);
               fwrite($file, "
                   <tr >
                       <td> $time </td>
                       <td> $dish </td>
                       <td> $ate->measure </td>
                       <td> $ate->kkal </td>
                   </tr>
              
               ");
           }
           fwrite($file, "</tbody></table>");

       }
       */
        // блок статей
        $i=0;
        if(isset($articles) && $arr['article_title']){

             fwrite($file, "<hr><h4>**Статьи**</h4>");
             foreach ($articles as $article) {
                 $i++;
                  fwrite($file, "<hr><h4>*".$i." ".$article->source->author->name." - - ".$article->source->title."</h4>");
                  fwrite($file, "<h4>".$article->minititle."</h4>");
                  fwrite($file, $article->body);
              }
        }
        //блок айтемов
        if(isset($arr['items'])){
            fwrite($file, "<hr><h4>**Краткости талантов**</h4>");
            foreach ($arr['items'] as $time => $item){
                $i++;
                fwrite($file, "<p class='mini'>*".$i." ".date('H:i',$time)." ");
                fwrite($file, $item->title."<br>");
                fwrite($file, " ".$item->source->title." - ".$item->source->author->name." - ".$item->cat->name."</p>");
                if($item->old_data) fwrite($file, "<p class='mini'>".$item->old_data."</p>");
                if($item->img){ fwrite($file, "<img src=/".$item->img.">");}
                fwrite($file, "<p>".nl2br($item->text)."</p>");
            }
        }
        //блок событий
        //var_dump($arr['events']);
        if(isset($arr['events'])){
            fwrite($file, "<hr><h4>**События**</h4>");
            foreach ($arr['events'] as $time => $event){
                $i++;
                fwrite($file, "<p class='mini'>*".$i." ".date('H:i',$time)." -");
                fwrite($file, $event->cat->name." - ");
                if($event->old_data) fwrite($file, " ".$event->old_data."</p>");
                else fwrite($file, "</p>");
                if($event->img){ fwrite($file, "<img src=/".$event->img.">");}
                fwrite($file, "<p>".nl2br($event->text)."</p>");
            }
        }

        fwrite($file, self::$footer);
        fclose($file);


    }

    function get_page($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвратить то что вернул сервер
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)");
        $data = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($httpCode == 200) ? $data : false;
    }

    function cut_content($content, $tag_in, $tag_out){

        $position = strpos($content, $tag_in, strlen($tag_in));
        $content = substr($content, $position);
        $position = strpos($content, $tag_out);

        return substr($content, 0, $position);

    }

    public function actionCurrencyTest()
    {
        //for($i=0; $i<45; $i++) {
                echo $i=0;

            $data_slash = Helper::getDateIntervalYesterdayInDashOrSlashFormat(new \DateTime(), $i, 'slash');
            $data_dash = Helper::getDateIntervalYesterdayInDashOrSlashFormat(new \DateTime(), $i, 'dash');

            $url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req='.$data_slash;

            $xml_contents = file_get_contents($url);
            if ($xml_contents === false)
                throw new \ErrorException('Error loading ' . $url);

            $xml = new \SimpleXMLElement($xml_contents);

            //$date = $xml->attributes()->Date;

            foreach ($xml as $node) {
                $current_curr = new CurrHistory();
                //var_dump($node->attributes()->ID);
                if(Currencies::find()->where('valute_id like "%'.$node->attributes()->ID.'%"')->one())
                   // var_dump(Currencies::find()->where('valute_id like "%'.$node->attributes()->ID.'%"')->one());
                   $current_curr->currency_id = Currencies::find()->where('valute_id like "%'.$node->attributes()->ID.'%"')->one()->id;
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


       // }


    }

    /**
     * Генерирует страницу с музыкой
     */
    public function actionMusicDirGenerator(){

        $music = fopen("/home/romanych/www/vrs/music.html", "w");
        fwrite($music, self::$header);

        $authors = Author::find()->where(['status' => 1])->all();

        foreach ($authors as $author){
            //var_dump($author->name);

            $alboms = Source::find()->where(['author_id' => $author->id])->all();
            $author_file = fopen("/home/romanych/www/vrs/music/".TranslateHelper::translit($author->name).".html", "w");
            fwrite($author_file, '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                            <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <style>.item_head{font-weight: bold;} body{padding-left: 20px; padding-top: 20px;} </style>');

            foreach ($alboms as $albom){

                $songs = Items::find()->where(['source_id' => $albom->id])->all();
                $songs_list = fopen("/home/romanych/www/vrs/music/".TranslateHelper::translit($albom->title).".html", "w");

                fwrite($songs_list, '<html><head>
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                            <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
                            <link href="/css/audio.css" rel="stylesheet" type="text/css" />
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
                            <script type="text/javascript" src="/js/js-jquery-ui-1.8.21.custom.min.js"></script>
                            <script>
                            var songs = [');
                foreach ($songs as $song) {
                    fwrite($songs_list, "{url:'$song->audio_link', name: '$author->name - $albom->title - $song->title'},");
                }

                 fwrite($songs_list, '];
                            </script>
                            <script type="text/javascript" src="/js/audio.js"></script>
                            </head>
                            <body>
                            <div>
                            <style>.item_head{font-weight: bold;} body{padding-left: 20px; padding-top: 20px;} </style>
                            <div id="audioPlayer" style="cursor: pointer">
                                <a onclick="playSound()">
                                    <p>Воспроизвести весь альбом</p>
                                </a>
                            </div>
                            <div id="currSong">
                            </div>
                         ');

                $r=1;

                foreach ($songs as $song) {
                    fwrite($songs_list, "<p class='item_head'>$r $song->title ($author->name - $albom->title)</p>
                    <audio controls>
                        <source src='".$song->audio_link."'>
                    </audio>
                    ".nl2br("<p>$song->text</p>")."

                    ");
                    $r++;
                }
                fwrite($songs_list, self::$footer);
                fclose($songs_list);

                fwrite($author_file, "<a href='".TranslateHelper::translit($albom->title).".html'><button type='button' class='btn btn-default btn-lg'> $albom->title </button></a>");
            }
            fwrite($author_file, self::$footer);
            fclose($author_file);

            fwrite($music, "<a href='music/".TranslateHelper::translit($author->name).".html'><button type='button' class='btn btn-default btn-lg'> $author->name </button></a>");
        }

        fwrite($music, self::$footer);
        fclose($music);
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

                    $ref = str_replace('/home/romanych','',$path);
                    var_dump(strstr($path,'gsdata'));

                    /*
                   if(strstr($path,'gsdata')) break;
                   if(strstr($path,'rutracker')) continue;

                   self::$str .= '<a href="'.$ref.'">'. htmlspecialchars($name). '</a>';

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

    /**
     * Генерируем матчи для прогнозов
     */
    public function actionPrognosematch(){
        $content = file_get_contents('/home/romanych/my/Моё/матчи2.txt');
        //$cont = explode('[block]', $content);
        $con = explode(PHP_EOL, $content);
        //var_dump($con); exit;
        $i = 0;
        $this->tournament = '';
        $chempionship = '';

        foreach ($con as $match){

            $match_arr = explode(' ', $this->clearMatchString($match));
            //var_dump($match_arr);

            $play = new Totmatch();

            if($i == 0) {
                $chempionship = $match;
            }

            if(isset($match_arr[0]) && $match_arr[0] == "Тур") {
                $this->tournament = $chempionship ." ". $match;
            }

            else {
                try {
                    $play->date = $match_arr[0] . "2017 " . $match_arr[1];
                    $play->host = $this->backTeamString($match_arr[2]);
                    $play->guest = $this->backTeamString($match_arr[3]);
                    $play->tournament = $this->tournament;
                    $play->foo_match_id = 1;
                    //var_dump($play);
                    $play->save();
                } catch (\ErrorException $e) {
                    $i++;
                    continue;
                }
            }
            $i++;

            //echo $this->tournament;

        }

    }

    public function clearMatchString($content){
        $content = str_replace(chr(9), ' ', $content);//Северная Ирландия
        $content = str_replace(chr(11), ' ', $content);  // заменяем табуляцию на пробел
        $content = str_replace(chr(13), ' ', $content);
        $content = str_replace(chr(10), ' ', $content);
        $content = str_replace('Северная Ирландия', 'Северная_Ирландия', $content);
        $content = str_replace('Спартак Москва 2', 'Спартак_Москва_2', $content);
        $content = str_replace('Спартак Нальчик', 'Спартак_Нальчик', $content);
        $content = str_replace('Зенит 2', 'Зенит_2', $content);
        $content = str_replace('Динамо Москва', 'Динамо_Москва', $content);
        $content = str_replace('SKA Khabarovsk', 'SKA_Khabarovsk', $content);
        $content = str_replace('Манчестер Юнайтед', 'Манчестер_Юнайтед', $content);
        $content = str_replace('Кристал Пэлас', 'Кристал_Пэлас', $content);
        $content = str_replace('Вест Бромвич', 'Вест_Бромвич', $content);
        $content = str_replace('Манчестер Сити', 'Манчестер_Сити', $content);
        $content = str_replace('Сток Сити', 'Сток_Сити', $content);
        $content = str_replace('Халл Сити', 'Халл_Сити', $content);
        $content = str_replace('Вест Хэм', 'Вест_Хэм', $content);
        $content = str_replace('Шахтер Донецк', 'Шахтер_Донецк', $content);
        $content = str_replace('Сталь Днепродзержинск', 'Сталь_Днепродзержинск', $content);
        $content = str_replace('Динамо Киев', 'Динамо_Киев', $content);
        $content = str_replace('Локомотив Москва', 'Локомотив_Москва', $content);
        $content = str_replace('Спартак Москва', 'Спартак_Москва', $content);
        $content = str_replace('Арсенал Тула', 'Арсенал_Тула', $content);
        $content = str_replace('Крылья Советов', 'Крылья_Советов', $content);
        return $content;
    }

    public function backTeamString($content){
        $content = str_replace('Северная_Ирландия', 'Северная Ирландия', $content);
        $content = str_replace('Спартак_Москва_2', 'Спартак Москва 2', $content);
        $content = str_replace('Спартак_Нальчик', 'Спартак Нальчик', $content);
        $content = str_replace('Зенит_2', 'Зенит 2', $content);
        $content = str_replace('Динамо_Москва', 'Динамо Москва', $content);
        $content = str_replace('SKA_Khabarovsk', 'SKA Khabarovsk', $content);
        $content = str_replace('Манчестер_Юнайтед', 'Манчестер Юнайтед', $content);
        $content = str_replace('Кристал_Пэлас', 'Кристал Пэлас', $content);
        $content = str_replace('Вест_Бромвич', 'Вест Бромвич', $content);
        $content = str_replace('Манчестер_Сити', 'Манчестер Сити', $content);
        $content = str_replace('Сток_Сити', 'Сток Сити', $content);
        $content = str_replace('Халл_Сити', 'Халл Сити', $content);
        $content = str_replace('Вест_Хэм', 'Вест Хэм', $content);
        $content = str_replace('Шахтер_Донецк', 'Шахтер Донецк', $content);
        $content = str_replace('Сталь_Днепродзержинск', 'Сталь Днепродзержинск', $content);
        $content = str_replace('Динамо_Киев', 'Динамо Киев', $content);
        $content = str_replace('Локомотив_Москва', 'Локомотив Москва', $content);
        $content = str_replace('Спартак_Москва', 'Спартак Москва', $content);
        $content = str_replace('Арсенал_Тула', 'Арсенал Тула', $content);
        $content = str_replace('Крылья_Советов', 'Крылья Советов', $content);
        return $content;
    }

    /**
     * Парсим xml с mts- детализацией
     */
    public function actionMtsDetalization()
    {
        $users_arr = [
            1 => 'sv_teldoc.xml',
            8 => 'rom_teldoc.xml',
            11 => 'mishach_teldoc.xml',
            12 => 'ba_teldoc.xml'
        ];

        foreach ($users_arr as $user => $user_file) {

            $dom = new \DomDocument();
            $url = Url::to("@app/commands/$user_file");
            $dom->load($url);
            $titles = $dom->getElementsByTagName("i");

            foreach ($titles as $node) {

                $rec = new Telbase();

                $datime_nach = $node->getAttribute('d');
                $ch = explode(" ", $datime_nach);
                $rec->date_nach = $ch[0];
                $rec->time_nach = $ch[1];
                $rec->nom_tel = $node->getAttribute('n');
                $rec->zak_gr = $node->getAttribute('zp');
                $rec->zv = $node->getAttribute('zv');
                $rec->source = $node->getAttribute('s');
                $rec->a = $node->getAttribute('a');
                $rec->dlitelnost = $node->getAttribute('du');
                $rec->c = $node->getAttribute('s');
                $rec->dut = $node->getAttribute('dup');
                $f = $node->getAttribute('f');
                $rec->f = str_replace(",", ".", $f);
                //echo floatval($f) . "<br />";
                $datime_okon = $node->getAttribute('bd');
                $ch = explode(" ", $datime_okon);
                $rec->date_okon = $ch[0];
                $rec->time_okon = $ch[1];
                $rec->cur = $node->getAttribute('cur');
                $rec->gmt = $node->getAttribute('gmt');
                $rec->user_id = $user;
                $rec->save();


            }

        }
    }

    /**
     * С Мейла парсим тв программу
     */
    public function actionYTvProgramm($general = 0){
        
        if($general) {
            $url = "https://tv.mail.ru/krasnojarsk/general/";
        }
        else {
            $url = "https://tv.mail.ru/krasnojarsk/sport/";
        }

        $content = $this->get_page($url);

        $tag_in = 'p-channels__items';
        $tag_out = 'sticky-springs sticky-springs_bottom js-springs__bottom';

        $position = strpos($content, $tag_in, strlen($tag_in));

        $content = substr($content, $position);
        $position = strpos($content, $tag_out);
        $content = substr($content, 0, $position);

        $allowedTags='<a><br><b><h1><h2><h3><h4><i>' .
            '<img><li><ol><p><strong><table>' .
            '<tr><td><th><u><ul>';

        $content = str_replace('</span>', PHP_EOL, $content);
        $content = str_replace('</div>', PHP_EOL, $content);

        $content = str_replace('<div class="p-channels__item__info__logo">', '-------------------------------------------------', $content);

        $content = strip_tags($content);

        echo $this->full_trim($content);
        
    }

    function full_trim($str)
    {
        return trim(preg_replace('/\s{2,}/', PHP_EOL, $str));

    }

    public function actionXmlTvProgram(){

        $p = gzfile("/home/romanych/Загрузки/xmltv.xml.gz");

        foreach ($p as $pr){
            if(strstr($pr, 'Спорт')) echo $pr;
        }

      // var_dump($p);

    }
    
    public function actionRssParser(){

        //$dom = new \DomDocument();
        $url = Url::to("http://www.moonconnection.com/moonconnection.rss");
        //$dom->load($url);

        $xmlstr = @file_get_contents($url);
        if($xmlstr===false)die('Error connect to RSS: '.$url);
        $xml = new \SimpleXMLElement($xmlstr);
        if($xml===false)die('Error parse RSS: '.$url);
        
        var_dump($xmlstr);
        
    }

    /***
     * Сравнение таблиц локалки и хостинга
     */
    public function actionBdAnalis(){
        $url1 = Url::to("@app/data/bd_local.txt");
        $url2 = Url::to("@app/data/bd_remote.txt");
        $arr1 = file($url1);
        $arr2 = file($url2);
        $arr3 = [];
        $i=0;

        foreach ($arr1 as $a){
            if(isset($arr2[$i]))$arr3[$a] = $arr2[$i];
            $i++;
        }
        print_r($arr3);
    }

    /**
     * Формирование плейлиста для радио
     */
    public function actionMakeRadioPlaylist($playlist=1) {
        $f = fopen("/home/romanych/radio/dio/playlist.txt", 'w');
        
        $audio = Items::find()->where("audio_link <> '' and play_status =".$playlist."")->orderBy('radio_que')->all();

        foreach ($audio as $item){
            if(strstr($item->audio_link, '/music')) {
                $one = str_replace('/music', 'music', $item->audio_link);
                fwrite($f, "/home/romanych/".$one.PHP_EOL);
            }

            else fwrite($f, "/home/romanych/Музыка/Thoughts_and_klassik/new_ideas/".$item->audio_link.PHP_EOL);

        }

        fclose($f);
        
        //var_dump($audio);
        
    }

    /**
     * Формирование плейлиста для радио с темой
     * Например $ php yii parsers/make-theme-radio-playlist 'дети, child, children'
     * Не забудем запустить ices
     */
    public function actionMakeThemeRadioPlaylist($words) {
        $f = fopen("/home/romanych/radio/dio/playlist.txt", 'w');

        $dibilizmy = Items::find()->where(["source_id" => 17])->all();
        shuffle($dibilizmy);
        $limerik = Items::find()->where(["source_id" => 27])->all();
        shuffle($limerik);
        
       // $this->songs = [];

        $arr_theme = explode(',', $words);

        //var_dump($arr_theme);

        if(empty($arr_theme))
            $this->songs = [];

        else {
            foreach ($arr_theme as $theme) {

                $query = new Query();

                $songs_ids = $query->from('songtexts')
                    ->match($theme)
                    ->all();


                foreach ($songs_ids as $arr_item_rec) {
                    foreach ($arr_item_rec as $id) {
                        $this->songs[] = SongText::findOne((int)$id);
                    }
                }

                $query_items_ids = $query->from('items')
                    ->match($theme)
                    ->all();

                foreach ($query_items_ids as $arr_item_rec){
                    foreach ($arr_item_rec as $id){
                        $this->songs[] = Items::findOne((int)$id);
                    }
                }
            }
        }


        shuffle($this->songs);

        foreach ($this->songs as $item){
            if($item instanceof Items && $item->audio_link)
                fwrite($f, "/home/romanych/Музыка/Thoughts_and_klassik/new_ideas/".$item->audio_link.PHP_EOL);
            if($item instanceof SongText)
                fwrite($f, "/home/romanych/Музыка/Thoughts_and_klassik".$item->link.PHP_EOL);

        }

        fclose($f);

        //var_dump($audio);

    }
    
    

    /**
     * Формирование рандомного (но с учетом статуса записи) плейлиста для радио
     */
    public function actionMakeRadioPlayListRandChess(){
        $f = fopen("/home/romanych/radio/dio/playlist.txt", 'w');
        $arr = [];
        $dibilizmy = Items::find()->where(["source_id" => 17])->all();
        shuffle($dibilizmy);
        $limerik = Items::find()->where(["source_id" => 27])->all();
        shuffle($limerik);
        $cavers = Items::find()->where(["source_id" => 38])->all();
        shuffle($cavers);
        $frazy = Items::find()->where("source_id = 181 or source_id = 37 or source_id = 30 or source_id = 29 or source_id = 25 or source_id = 20")->all();
        shuffle($frazy);
        $peredelki = Items::find()->where(["source_id" => 19])->all();
        shuffle($peredelki);
        $pesni = Items::find()->where(["source_id" => 6])->all();
        shuffle($pesni);

        for($i=0; $i<1000; $i++){
            if(isset($dibilizmy[$i]))
                array_push($arr, $dibilizmy[$i]);
            if(isset($limerik[$i]))
                array_push($arr, $limerik[$i]);
            if(isset($cavers[$i]))
                array_push($arr, $cavers[$i]);
            if(isset($frazy[$i]))
                array_push($arr, $frazy[$i]);
            if(isset($peredelki[$i]))
                array_push($arr, $peredelki[$i]);
            if(isset($pesni[$i]))
                array_push($arr, $pesni[$i]);
            

        }
        foreach ($arr as $item){
            if(strstr($item->audio_link, '/music')) {
                $one = str_replace('/music', 'music', $item->audio_link);
                fwrite($f, "/home/romanych/".$one.PHP_EOL);
            }
            elseif ($item->audio_link) fwrite($f, "/home/romanych/Музыка/Thoughts_and_klassik/new_ideas/".$item->audio_link.PHP_EOL);

        }

        fclose($f);
       // print_r($arr);
    }

    /**
     * Рендеринг проигрывателя
     * @param $audio_link
     * @return string
     */
    public function renderPlayer($audio_link){
        if($audio_link !== '') {
            return "<audio controls>
                    <source src='../../".$audio_link."'>
                </audio>";
        }
        else return '';

    }

    /**
     * Парсим сводные таблицы команд
     */
    public function actionFillRusianPlTotal(){
        $content = file('/home/romanych/my/Моё/матчи3.txt');
        //print_r($content); exit;
        for($i=0; $i<1087; $i+=2){
            if(preg_match("/[А-Я]+/", $content[$i])) { //echo $content[$i];
                $team = new TeamSum();
                $team->tournament_id = 3;
                //$team->name = substr($content[$i], 3);
                $team->name = ucfirst(mb_convert_case(lcfirst(trim($content[$i])), MB_CASE_TITLE, "UTF-8" ));
                //mb_convert_case($name, MB_CASE_TITLE, "UTF-8")
                //echo $team->name." name";
                $team->mem = (int)$content[$i+18];
                $team->play = (int)$content[$i+20];

                $team->vic = (int)$content[$i+22];
                $team->nob = (int)$content[$i+24];
                $team->def = (int)$content[$i+26];
                //$m = explode('-',$content[$i+12]);
                //$team->goal_g = $m[0];
                //$team->goal_l = $m[1];
                $team->balls = (int)$content[$i+28];
               // var_dump($team);
                $team->save(false);
            }


        }
    }

    public function actionFillByEuropeClubTeams(){
        $top_europe_club_teams = [
            'Спартак Москва',
            'ЦСКА',
            'Зенит'


        ];
    }

    /**
     * Коэффициенты УЕФА
     */
    public function actionParsRatingUefaTeams(){
        $url = "http://www.profootball.ua/ranking/uefa_teams.html";
        $content = $this->cut_content($this->get_page($url), 'class="t1"', 'UEFA Ranking By Bert Kassies');
        $dom = new \DomDocument();
        libxml_use_internal_errors(true);
        $head = file_get_contents(Url::to("@app/commands/header.html"));
        $teams = $head . $content; //добавляем хэдер
        $dom->loadHTML($teams);


        $tr = $dom->getElementsByTagName("tr");
        foreach ($tr as $node) {
            $dom_in = new \DomDocument();
            $html = $node->ownerDocument->saveHTML($node);
            libxml_use_internal_errors(true);
            $newhtml = $head . $html;
            $dom_in->loadHTML($newhtml);


            $td = $dom_in->getElementsByTagName("td");
            foreach ($td as $node) {
                echo $node->nodeValue.PHP_EOL;
               if($td[2]->nodeValue == 'Rus') break;
                $team = new TeamSum();
                $team->tournament_id = 2;
                $team->alias = $td[1]->nodeValue;
                $team->country = $td[2]->nodeValue;
                $team->rank1old = $td[3]->nodeValue;
                $team->rank2old = $td[4]->nodeValue;
                $team->rank3old = $td[5]->nodeValue;
                $team->rank4old = $td[6]->nodeValue;
                $team->rank5old = $td[7]->nodeValue;
                $team->rank = $td[8]->nodeValue;
                $team->save(false);
                break;
            }
            echo "--------------------".PHP_EOL;

        }


    }
    
    public function actionParsNgnxLog(){
        $content = file('/var/log/nginx/access.log');
        var_dump($content);
    }

    /**
     * Парсим в базу данные шагомера
     */
    public function actionOrmon(){
        $cont = file_get_contents("/home/romanych/public_html/plis/basic/web/uploads/walking/ormon.txt");
        $tag_in = '.'.date('Y', time());

        $position = strpos($cont, $tag_in);
        $cont = substr($cont, $position);
        $cont = str_replace('  ', ' ', $cont);
        $cont = str_replace(chr(9), ' ', $cont);
        $cont = str_replace(chr(11), ' ', $cont);

        $cht = explode(" ", $cont);

        $ormon = new Ormon();
        $ormon->year = date('Y', time());
        $ormon->day = date('d', time());
        $ormon->month = date('m', time());
        $ormon->dd = date('D', time());
        $ormon->totalstep = (int)$cht[1];
        $ormon->aerostep = (int)$cht[2];
        $ormon->aerowalktime = (int)$cht[3];
        $ormon->calories = (int)$cht[4];
        $ormon->distance = (float)$cht[5];
        $ormon->fatburned = (float)$cht[6];
        $ormon->steph1 = (int)$cht[7];
        $ormon->steph2 = (int)$cht[8];
        $ormon->steph3 = (int)$cht[9];
        $ormon->steph4 = (int)$cht[10];
        $ormon->steph5 = (int)$cht[11];
        $ormon->steph6 = (int)$cht[12];
        $ormon->steph7 = (int)$cht[13];
        $ormon->steph8 = (int)$cht[14];
        $ormon->steph9 = (int)$cht[15];
        $ormon->steph10 = (int)$cht[16];
        $ormon->steph11 = (int)$cht[17];
        $ormon->steph12 = (int)$cht[18];
        $ormon->steph13 = (int)$cht[19];
        $ormon->steph14 = (int)$cht[20];
        $ormon->steph15 = (int)$cht[21];
        $ormon->steph16 = (int)$cht[22];
        $ormon->steph17 = (int)$cht[23];
        $ormon->steph18 = (int)$cht[24];
        $ormon->steph19 = (int)$cht[25];
        $ormon->steph20 = (int)$cht[26];
        $ormon->steph21 = (int)$cht[28];
        $ormon->steph22 = (int)$cht[29];
        $ormon->steph23 = (int)$cht[30];
        $ormon->steph24 = (int)$cht[31];
        $ormon->aerosteph1 = (int)$cht[32];
        $ormon->aerosteph2 = (int)$cht[33];
        $ormon->aerosteph3 = (int)$cht[34];
        $ormon->aerosteph4 = (int)$cht[35];
        $ormon->aerosteph5 = (int)$cht[36];
        $ormon->aerosteph6 = (int)$cht[37];
        $ormon->aerosteph7 = (int)$cht[38];
        $ormon->aerosteph8 = (int)$cht[39];
        $ormon->aerosteph9 = (int)$cht[40];
        $ormon->aerosteph10 = (int)$cht[41];
        $ormon->aerosteph11 = (int)$cht[42];
        $ormon->aerosteph12 = (int)$cht[43];
        $ormon->aerosteph13 = (int)$cht[44];
        $ormon->aerosteph14 = (int)$cht[45];
        $ormon->aerosteph15 = (int)$cht[46];
        $ormon->aerosteph16 = (int)$cht[47];
        $ormon->aerosteph17 = (int)$cht[48];
        $ormon->aerosteph18 = (int)$cht[49];
        $ormon->aerosteph19 = (int)$cht[50];
        $ormon->aerosteph20 = (int)$cht[51];
        $ormon->aerosteph21 = (int)$cht[52];
        $ormon->aerosteph22 = (int)$cht[53];
        $ormon->aerosteph23 = (int)$cht[54];
        $ormon->aerosteph24 = (int)$cht[55];
        if($ormon->save()) {

            $act = new DiaryActs();
            $act->model_id = 11;
            $act->user_id = 8;
            $act->mark = round($ormon->totalstep/1000);
            if($act->save(false)) echo 'ok';

        }
    }

    /**
     * Снимок дня
     * @throws \Exception
     */
    public function actionSnapshot(){

        //$data = $this->cut_content($this->get_page("http://redday.ru/moon/"),'maintext', '/sun/sunrise.asp');
        //var_dump($data); exit;


        $start_time = strtotime('now 00:00:00', time()+7*60*60);

        //$start_time = mktime(7, 0, 0, 12, 27, 2016);
        //echo  date('Y-d-m H:h', $start_time); exit;
        
        $snapshot = new Snapshot();
        $today_mark = DiaryActs::find()
            ->select('SUM(mark)')
            ->where("user_id = 8 and time > ".$start_time)
            ->scalar();

        if($today_mark) $snapshot->oz = $today_mark;
        else $snapshot->weight = 0;
        
        $snapshot->doll = Helper::currencyAdapter(1, 11);
        $snapshot->euro = Helper::currencyAdapter(1, 12);
        
        if(DiaryRecDayParams::find()->where(['day_param_id' => 1])->orderBy('id DESC')->one())
            $snapshot->weight = (float)DiaryRecDayParams::find()->where(['day_param_id' => 1])->orderBy('id DESC')->one()->value;
        else $snapshot->weight = 0;

        $mish_mark = DiaryActs::find()
            ->select('SUM(mark)')
            ->where("time > $start_time and user_id = 11")
            ->scalar();
        if($mish_mark) $snapshot->mish_oz = $mish_mark;
        else $snapshot->mish_oz = 0;

        $today_acts = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > $start_time and user_id = 8 and model_id = 1")->all(), 'id', 'id'));
        $snapshot->kkal = DiaryAte::find()
            ->select('SUM(kkal)')
            ->where("act_id  IN (" . $today_acts . ")")
            ->scalar();

        $not_curr_sum = Incomes::find()
            ->select('SUM(money)')
            ->where("income_id  IN (1,2,7,10)")
            ->scalar();
        $dollar = Incomes::find()
            ->select('SUM(money)')
            ->where("income_id  = 8")
            ->scalar();
        $euro = Incomes::find()
            ->select('SUM(money)')
            ->where("income_id  = 9")
            ->scalar();
        $snapshot->useful_bal = (int)($not_curr_sum + Helper::currencyAdapter($dollar, 11) + Helper::currencyAdapter($euro, 12));

        $snapshot->sun_rise = date_sunrise(time(), SUNFUNCS_RET_STRING, 55, 82, 90, 7);
        $snapshot->sun_set = date_sunset(time(), SUNFUNCS_RET_STRING, 55, 82, 90, 7);

        try {
            $el112 = DiaryRecDayParams::find()
                ->where('day_param_id = 4')
                ->orderBy('id DESC')
                ->all();
            $cold_water = DiaryRecDayParams::find()
                ->where('day_param_id = 2')
                ->orderBy('id DESC')
                ->all();
            $hot_water = DiaryRecDayParams::find()
                ->where('day_param_id = 3')
                ->orderBy('id DESC')
                ->all();
            $el111 = DiaryRecDayParams::find()
                ->where('day_param_id = 25')
                ->orderBy('id DESC')
                ->all();

            if ($el112) $snapshot->el112 = (int)$el112[0]->value - (int)$el112[1]->value;
            if ($cold_water) $snapshot->water_cold = ($cold_water[0]->value - $cold_water[1]->value)*1000;
            if ($hot_water) $snapshot->water_hot = ($hot_water[0]->value - $hot_water[1]->value)*1000;
            if ($el111) $snapshot->el111 = (int)$el111[0]->value - (int)$el111[1]->value;
        } catch (\ErrorException $e) {
            $snapshot->el112 = 0;
            $snapshot->water_cold = 0;
            $snapshot->water_hot = 0;
            $snapshot->el111 = 0;
        }
       // echo $snapshot->water_hot;


       // exit;
        

        $today_acts_bought = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > $start_time and user_id = 8 and model_id = 3")->all(), 'id', 'id'));

        $bought_today = [];
        $sum_spent = 0;

        if ($today_acts_bought) {
            try {
                //return var_dump($bought_today);
                $snapshot->spent = Bought::find()->select('SUM(spent)')->where("act_id  IN (" .  $today_acts_bought . ")")->scalar();
            } catch (\ErrorException $e) {
                return $e->getMessage();
            }

            
            // return var_dump($sum_spent );
        }

       if($snapshot->save()) {


            $act = new DiaryActs();
            $act->model_id = 12;
            $act->user_id = 8;
            $klavaro_balls = 0;

            $today_acts_of_day_params = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > $start_time and user_id = 8 and model_id = 4")->all(), 'id', 'id'));
            if( $today_acts_of_day_params) {
                $klavaro_eng_today = DiaryRecDayParams::find()
                    ->where("act_id  IN (" . $today_acts_of_day_params . ") and day_param_id = 22")
                    ->one();
                $klavaro_ru_today = DiaryRecDayParams::find()
                    ->where("act_id  IN (" . $today_acts_of_day_params . ") and day_param_id = 23")
                    ->one();
            }

            if(isset($klavaro_eng_today) && $klavaro_eng_today->value > 95 )  $klavaro_balls = 1;
            if(isset($klavaro_ru_today) && $klavaro_ru_today->value  > 95 )  $klavaro_balls += 1;

            //$klavaro_balls = ( isset($klavaro_eng_today) ? $klavaro_eng_today->value : 0 ) + ( isset($klavaro_ru_today) ? $klavaro_eng_today->value : 0 );
            //echo $klavaro_balls;
            
            if(DiaryRecDayParams::find()->where(['day_param_id' => 18])->orderBy('id DESC')->one())    {
                $act->mark =  (int)round(DiaryRecDayParams::find()->where(['day_param_id' => 18])->orderBy('id DESC')->one()->value/2000) + $klavaro_balls;
            }
    
            else $act->mark = 0;
    
            $snapshot->oz += $act->mark;
            $snapshot->update();
    
           // var_dump($act);
    
    
            if($act->save(false)) echo 'ok';

        }

        //var_dump($snapshot);


    }

    /**
     * Парсер хабрахабра
     * @param $url
     */
    public function actionHabrParser($url, $title){
        $tag_in = '';
        $tag_out = '';
        $cut = '';
        $source = 329;

        if(strstr($url, 'habrahabr.ru/company')){
            $tag_in = 'class="company_post"';
            $tag_out = 'class="post__tags"';

        }

        elseif(strstr($url, 'habrahabr') || strstr($url,'geektimes')) {
            $tag_in = 'class="post_show"';
            $tag_out = 'class="post__tags"';

        }

        elseif(strstr($url, 'wikipedia')) {
            $tag_in = 'id="mw-content-text"';
            $tag_out = 'printfooter';
            $source = 394;

        }

        elseif(strstr($url, 'highload')) {
            $tag_in = 'page_wrapper';
            $tag_out = 'social-likes social-likes_visible';
            $source = 394;

        }

        //echo $tag_in;
        //echo $tag_out;  exit;

        header('Content-Type: text/html; charset=utf-8');
        //$head = file_get_contents(Url::to("@app/commands/header.html"));
       
        $content = $this->get_page($url);

        $content = $this->cut_content($content, $tag_in, $tag_out);

        $allowedTags='<a><br><b><h1><h2><h3><h4><i>' .
            '<img><li><ol><p><strong><table><pre>' .
            '<tr><td><th><u><ul>';
        $content = strip_tags($content, $allowedTags);
        $content = preg_replace('$\[.*?\]$','',$content);
        $content = str_replace('id="mw-content-text" lang="ru" dir="ltr" class="mw-content-ltr">', '', $content);

       
        $artContent = new ArticlesContent;
        $artContent->articles_id = (int)Articles::find()
            ->select('MAX(id)')
            ->scalar();
        $artContent->source_id = $source;
        $artContent->body = $content;
        $artContent->minititle = $title;
        $artContent->save(false);
        //var_dump($artContent);


    }
    

    function get_picture($url, $target){
/*
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
            $out = curl_exec($ch);
            $image_sv = $target.'.jpg';
            $img_sc = file_put_contents($image_sv, $out);
            curl_close($ch);
*/

        $ch = curl_init($url);

        //curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.95 Safari/537.11');

        $content = curl_exec($ch);
        curl_close($ch);

        if (file_exists($target)) :
            unlink($target);
        endif;
            
        $fp = fopen($target , 'x');
        fwrite($fp, $content);
        fclose($fp);

        /*
        if(!$hfile = fopen($target, "w")) return false;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.95 Safari/537.11');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FILE, $hfile);
        if(!curl_exec($ch)){
            var_dump($url);
            curl_close($ch);
            fclose($hfile);
            unlink($target);
            return false;
        }
        fflush($hfile);
        fclose($hfile);
        curl_close($ch);
        return true;
        */
    }


    /**
     * Парсинг ссылок на песни в таблицу текстов
     */
    function actionGetMusicLinks(){
        $dir = '/home/romanych/Музыка/Thoughts_and_klassik/best_alboms';
        $authors = scandir($dir);

        //return var_dump($list);

        if (is_array($authors)) {

            $authors = array_diff($authors, array('.', '..'));
            if ($authors) {

                foreach ($authors as $author) {

                    $path = $dir . '/' . $author;

                    if (is_dir($path))
                        $alboms = scandir($path);

                        if(is_array($alboms)){
                            $alboms = array_diff($alboms, array('.', '..'));

                            if($alboms){
                                foreach ($alboms as $albom){
                                    

                                    $path = $dir .'/'. $author .'/'. $albom;


                                    if($source = Source::find()->where("title like '%".addslashes($albom)."%'")->one()) {

                                        echo $source->title;
                                        //exit;
                                    }
                                    else  continue;


                                    if(is_dir($path)) {
                                        $songs = scandir($path);
                                        $songs = array_diff($songs, array('.', '..'));
                                        foreach ($songs as $song){
                                            
                                            $song_obj = new SongText();
                                            try {
                                                $song_obj->source_id = $source->id;
                                            } catch (\ErrorException $e) {
                                                echo $e->getMessage();
                                                continue;
                                            }

                                            $song_path = $path .'/'.$song;
                                            if(is_dir($song_path)) {
                                                $sub_songs = scandir($song_path);
                                                $sub_songs = array_diff($sub_songs, array('.', '..'));
                                                foreach ($sub_songs as $sub_song){
                                                    if(preg_match('/(.+).mp3$/',$sub_song, $match))
                                                        $song_obj->title = $sub_song;
                                                        $song_obj->link = $path .'/'. $song .'/'. $sub_song;

                                                }
                                            }
                                            else
                                                if(preg_match('/(.+).mp3$/',$song, $match)) {
                                                    $song_obj->title = $song;
                                                    $song_obj->link = $path .'/'. $song;
                                                }

                                            $song_obj->save(false);
                                        }
                                    }
                                    else{
                                      echo $path.'-----no---dir--------------';
                                    }

                                }
                            }


                        }

                }

            }
        }
        else {
            echo 'cant';
        }

    }

    /**
     * Для обрезки ссылки в базе песен
     */
   function actionSongTextCutLink(){
       
       for ($i=25; $i<=6069; $i++) {
           if(SongText::findOne($i) && SongText::findOne($i)->link != null) {
               $song = SongText::findOne($i);
               $song->link = substr(SongText::findOne($i)->link, 48);
               //echo $song->link.PHP_EOL;
               $song->update(false);
               echo $i.PHP_EOL;
           }

       }

   }

    /***
     * Создание записей в таблице текстов песен по директориям с музыкой
     * @param $new_artist
     * @return string
     */
    function actionGetMusicLinksAlbom($new_artist){
        $dir = '/home/romanych/Музыка/Thoughts_and_klassik/best_alboms/'.$new_artist;

        //return var_dump($dir);

        try {
            $alboms = scandir($dir);
        } catch (\ErrorException $e) {
           return $e->getMessage();
        }

        if(is_array($alboms)){
            $alboms = array_diff($alboms, array('.', '..'));

            if($alboms){
                foreach ($alboms as $albom){

                   // return var_dump($albom);

                    $source = new Source();

                    $source->title = $albom;
                    
                    if(Author::find()->where('name like "%'.addslashes($new_artist).'%"')->one())
                        $source->author_id = Author::find()->where("name like '%".addslashes($new_artist)."%'")->one()->id;
                    else return('author error');
                    
                    $source->status = 1;
                    $source->cat_id = 34;
                    if(!$source->save(false)) return 'source error';
                    else echo $source->title.' made'.PHP_EOL;

                    $path = $dir .'/'. $albom;


                    if(is_dir($path)) {
                        $songs = scandir($path);
                        $songs = array_diff($songs, array('.', '..'));
                        foreach ($songs as $song){

                            $song_obj = new SongText();
                            try {
                                $song_obj->source_id = $source->id;
                            } catch (\ErrorException $e) {
                                echo $e->getMessage();
                                continue;
                            }

                            $song_path = $path .'/'.$song;
                            if(is_dir($song_path)) {
                                $sub_songs = scandir($song_path);
                                $sub_songs = array_diff($sub_songs, array('.', '..'));
                                foreach ($sub_songs as $sub_song){
                                    if(preg_match('/(.+).mp3$/',$sub_song, $match))
                                        $song_obj->title = $sub_song;
                                    $song_obj->link = substr($path .'/'. $song .'/'. $sub_song, 48);

                                }
                            }
                            else
                                if(preg_match('/(.+).mp3$/',$song, $match)) {
                                    $song_obj->title = $song;
                                    $song_obj->link = substr($path .'/'. $song, 48);
                                }

                            $song_obj->save(false);
                        }
                    }
                    else{
                        echo $path.'-----no---dir--------------';
                    }

                }
            }


        }


    }

    /**
     * Заполнение таблицы Погода XXI
     * 
     */
    function actionFillPogodaxxi(){
       $time_first = mktime(0, 0, 0, 1, 1, 2001); 
        $time_end = mktime(0, 0, 0, 1, 1, 2009);
        // echo date('d-m-Y',$time_first).PHP_EOL;
        //echo date('d-m-Y',$time_first+(60*60*24)).PHP_EOL;
        $i=0;
        //$time = $time_first;
        while($i < 3650 ){
            $i++;
            if($time_first+(60*60*24*$i) > $time_end) break;
            //$time += $time_first+(60*60*24);
            $day = new PogodaXXI();
            $day->year = (int)date('Y', $time_first+(60*60*24*$i));
            $day->date = (int)date('j', $time_first+(60*60*24*$i));
            $day->month = (int)date('n', $time_first+(60*60*24*$i));
            $day->week = (int)date('W', $time_first+(60*60*24*$i));
            $day->day_week = (int)date('w', $time_first+(60*60*24*$i));
            $day->save(false);
            
            echo date('d-m-Y', $time_first+(60*60*24*$i)).' done '.PHP_EOL;
            
            
        }
    }
    
    function actionFillSnapshotByCounters(){
        $recs = Snapshot::find()->where('id > 60')->all();
        $prev_el112 = 0;
        $prev_hot_wat = 0;
        $prev_cold_wat = 0;
        $prev_el111 = 0;


        foreach ($recs as $rec){

            $data = explode('-',$rec->date);
            $year = (int)$data[0]; $month = (int)$data[1]; $day = (int)$data[2];

            $time_max = mktime(23, 59, 59, $month, $day, $year);
            $time_min = mktime(23, 59, 59, $month, $day, $year) - 24*60*60;

            $obj_el112 = DiaryRecDayParams::find()
                ->where('day_param_id = 4 and act_id <'.$this->getActIdByTimestamp($time_max).' and act_id >'.$this->getActIdByTimestamp($time_min))
                ->orderBy('id DESC')
                ->one();
            $obj_hot_wat = DiaryRecDayParams::find()
                ->where('day_param_id = 3 and act_id <'.$this->getActIdByTimestamp($time_max).' and act_id >'.$this->getActIdByTimestamp($time_min))
                ->orderBy('id DESC')
                ->one();
            $obj_cold_wat = DiaryRecDayParams::find()
                ->where('day_param_id = 2 and act_id <'.$this->getActIdByTimestamp($time_max).' and act_id >'.$this->getActIdByTimestamp($time_min))
                ->orderBy('id DESC')
                ->one();
            $obj_el111 = DiaryRecDayParams::find()
                ->where('day_param_id = 25 and act_id <'.$this->getActIdByTimestamp($time_max).' and act_id >'.$this->getActIdByTimestamp($time_min))
                ->orderBy('id DESC')
                ->one();



            if($obj_el112)$rec->el112 = round((float)$obj_el112->value - $prev_el112);
            else $rec->el112 = 0;

            if($obj_hot_wat)$rec->water_hot = ((float)$obj_hot_wat->value - $prev_hot_wat)*1000;
            else $rec->water_hot = 0;

            if($obj_cold_wat)$rec->water_cold = ((float)$obj_cold_wat->value - $prev_cold_wat)*1000;
            else $rec->water_cold = 0;

            //var_dump(round((float)$obj_cold_wat->value - $prev_cold_wat, 3)); exit;

            if($obj_el111)$rec->el111 = round((float)$obj_el111->value - $prev_el111);
            else $rec->el111 = 0;


            $rec->update(false);

            if($obj_el112)$prev_el112 = (float)$obj_el112->value;
            if($obj_hot_wat)$prev_hot_wat = (float)$obj_hot_wat->value;
            if($obj_cold_wat)$prev_cold_wat = (float)$obj_cold_wat->value;
            if($obj_el111)$prev_el111 = (float)$obj_el111->value;

        }

    }

    /**
     * Максимальный айдишник действия по метке
     * @param $time
     * @return int
     */
    function getActIdByTimestamp($time){

        return   (int)DiaryActs::find()
            ->select('MAX(id)')
            ->where('time <'.$time)
            ->scalar();
    }
    


   
}