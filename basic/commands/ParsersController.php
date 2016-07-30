<?php
namespace app\commands;


use app\models\Author;
use app\models\Currencies;
use app\models\CurrHistory;
use app\models\Items;
use app\models\Source;
use app\models\Tag;
use app\models\TeamSum;
use app\models\Telbase;
use app\models\Totmatch;
use yii\console\Controller;
use yii\helpers\Url;
use Yii;
use app\components\Helper;
use app\components\TranslateHelper;


class ParsersController extends Controller
{
    public $arr = [];
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
        $dom = new \DomDocument();
        $url = Url::to("@app/commands/teldoc.xml");
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
            $rec->save();


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

        for($i=0; $i<100; $i++){
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

            else fwrite($f, "/home/romanych/Музыка/Thoughts_and_klassik/new_ideas/".$item->audio_link.PHP_EOL);

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
        //print_r($content);
        for($i=0; $i<703; $i+=2){
            if(strstr($content[$i],'.')) {
                $team = new TeamSum();
                $team->tournament_id = 1;
                //$team->name = substr($content[$i], 3);
                $team->name = trim(mb_substr($content[$i],3,20,'UTF-8'));
                //echo $team->name." name";
                $team->mem = $content[$i+2];
                $team->play = $content[$i+4];
                $team->vic = $content[$i+6];
                $team->nob = $content[$i+8];
                $team->def = $content[$i+10];
                $m = explode('-',$content[$i+12]);
                $team->goal_g = $m[0];
                $team->goal_l = $m[1];
                $team->balls = $content[$i+14];
                $team->save(false);
            }


        }
    }
    
}