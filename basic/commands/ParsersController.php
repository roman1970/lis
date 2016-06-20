<?php
namespace app\commands;


use app\models\Author;
use app\models\Currencies;
use app\models\CurrHistory;
use app\models\Items;
use app\models\Source;
use app\models\Tag;
use yii\console\Controller;
use yii\helpers\Url;
use Yii;
use app\components\Helper;
use app\components\TranslateHelper;


class ParsersController extends Controller
{
    public $arr = [];
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

    public static $footer = "</body></html></div>";

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
                    <audio controls>
                        <source src='../../".$item->audio_link."'>
                    </audio>
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
     * Генерирует страницу с деревом файлов музыкальной директории
     */
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
}