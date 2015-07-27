<?php 

namespace app\commands;
use Yii;
use yii\console\Controller;
use app\components\rbac\UserRoleRule;

class PogodaController extends Controller
{
    private $cityUrls;
    private $city;
    private $vyspok = 0;
    private $osad12 = 0;
    private $osad24 = 0;
    private $gorvid = 0;
    private $balobl = 0;
    private $scorvetra = 0;
    private $naprvetra = 0;
    private $otnvlaz = 0;
    private $temp = 0;
    private $atmdavlnaurst = 0;
    
    
    public function run()
    {

	//$db = mysql_connect ("PogodaOS", "roma70", "3htz0tk");
	//mysql_select_db ("weather",$db);


	$y = date("Y");
	$d = date("d");
	$me = date("m");
	$dod = date("D");
	$chas = date("H");
	$date = date("d-m-Y");
 

	$this->cityUrls = [
	    "http://meteoinfo.ru/pogoda/russia/novosibirsk-area/novosibirsk", 
	    "http://meteoinfo.ru/pogoda/russia/moscow-area/moscow", 
	    "http://meteoinfo.ru/pogoda/russia/krasnoyarsk-territory/krasnojarsk",
	    "http://meteoinfo.ru/pogoda/russia/astrakhan-area/astrahan",
	    "http://meteoinfo.ru/pogoda/russia/republic-altai/gorno-altajsk",
	    "http://meteoinfo.ru/pogoda/russia/altai-territory/barnaul",
	    "http://meteoinfo.ru/pogoda/russia/republic-bashkortostan/ufa",
	    "http://meteoinfo.ru/pogoda/russia/republic-dagestan/mahackala",
	    "http://meteoinfo.ru/pogoda/russia/voronezh-area/voronez",
	    "http://meteoinfo.ru/pogoda/russia/volgograd-area/volgograd",
	    "http://meteoinfo.ru/pogoda/russia/krasnodar-territory/adler",
	    "http://meteoinfo.ru/pogoda/russia/kaliningrad-area/kaliningrad",
	    "http://meteoinfo.ru/pogoda/russia/kamchatka-area/petropavlovsk-",
	    "http://meteoinfo.ru/pogoda/russia/kemerovo-area/kemerovo",
	    "http://meteoinfo.ru/pogoda/russia/magadan-area/magadan",
	    "http://meteoinfo.ru/pogoda/russia/murmansk-area/murmansk",
	    "http://meteoinfo.ru/pogoda/russia/nizhegorodskaya-area/niznij-novgoro",
	    "http://meteoinfo.ru/pogoda/russia/novosibirsk-area/culym",
	    "http://meteoinfo.ru/pogoda/russia/omsk-area/omsk",
	    "http://meteoinfo.ru/pogoda/russia/primorski-krai/vladivostok",
	    "http://meteoinfo.ru/pogoda/russia/rostov-area/rostov-na-donu",
	    "http://meteoinfo.ru/pogoda/russia/republic-saha-yakutia/jakutsk",
	    "http://meteoinfo.ru/pogoda/russia/ryazan-area/rjazan",
	    "http://meteoinfo.ru/pogoda/russia/samara-area/samara",
	    "http://meteoinfo.ru/pogoda/russia/sverdlovsk-area/ekaterinburg",
	    "http://meteoinfo.ru/pogoda/russia/republic-tatarstan/kasan",
	    "http://meteoinfo.ru/pogoda/russia/tomsk-area/tomsk",
	    "http://meteoinfo.ru/pogoda/russia/khabarovsk-territory/habarovsk",
	    "http://meteoinfo.ru/pogoda/russia/hanty-mansijskij-ar/hanty-mansijsk",
	    "http://meteoinfo.ru/pogoda/russia/chukotskij-ar/anadyr",
	    "http://meteoinfo.ru/pogoda/russia/yaroslavl-area/jaroslavl"
	];

	foreach ($this->cityUrls as $url) {
	    $arrTableFields = preg_split("$\/$", $url); // разбиваем ссылку, выделяя город - название таблицы
	    $cityField = str_replace("-", "_", $arrTableFields[count($arrTableFields)-1]) ;
	    $content = file_get_contents($url);

	}
    }


//echo $n = count($cities);
 
    //   $link = $cities[$z]; 
    //   print_r($cities);
	//   $r = preg_split("$\/$", $link); // разбиваем ссылку, выделяя город - название таблицы
    //   print_r ($r); 
//	   $j = count($r)-1;
	//   echo $gorod = $r[$j];
     //      if($gorod == 'gorno-altajsk') $gorod = 'gorno_altajsk';
     //      if($gorod == 'petropavlovsk-') $gorod = 'petropavlovsk';
     //      if($gorod == 'niznij-novgoro') $gorod = 'niznij_novgorod';
      //     if($gorod == 'rostov-na-donu') $gorod = 'rostov_na_donu';
      //     if($gorod == 'hanty-mansijsk') $gorod = 'hanty_mansijsk';
//$vyspok = 0;
// $osad12 = 0;
// $osad24 = 0;
// $gorvid = 0;
// $balobl = 0;
// $scorvetra = 0;
/// $naprvetra = 0;
 //$otnvlaz = 0;
// $temp = 0;
// $atmdavlnaurst = 0;
 
//$content = file_get_contents($link);
/*
$tag_in = 'Атмосферное давление';
$tag_out = ' ';

$e = strstr($content, $tag_in);
if ($e) {

$position = strpos($content, $tag_in);
$content = substr($content, $position);

$content = strip_tags($content);
$content = str_replace('&deg;C', ' ', $content);  
 while(strpos($content,'  ')!==false)  // удаляем последовательности пробелов
 {
   $content = str_replace('  ',' ',$content);
 }; 
$content = str_replace('  ', ' ', $content);  
$content = str_replace('   ', ' ', $content);  
$content = str_replace('Погода', '', $content); 
$content = str_replace('Комментарий к погоде', '', $content); 
$content = str_replace('Ливневой дождь слабый', '', $content);
$content = str_replace('Количество облаков увеличилось', '', $content);
$content = str_replace('Ливневый дождь', '', $content);
$content = str_replace('Дымка (видимость больше 1 км)', '', $content);
$content = str_replace('Ухудшение видимости из-за дыма или вулканического пепла', '', $content);
$content = str_replace('Туман (видимость менее 1 км)', '', $content);
$content = str_replace('Туман ослабел (небо не видно)', '', $content);
$content = str_replace('Гроза слабая или умеренная (возможен дождь или снег)', '', $content);

$content  = str_replace(chr(9),' ', $content);
$content  = str_replace(chr(11),' ', $content);
$content  = str_replace(chr(13),' ', $content);

$gmc = explode(" ", $content);

for ($i=0; $i<50; $i++) { if ($gmc[$i] == 'уровне' && $gmc[$i+1] == 'станции,'){
$atmdavlnaurst = $gmc[$i+7]; break;}}
for ($i=8; $i<50; $i++) { if ($gmc[$i] == 'Температура' && $gmc[$i+1] == 'воздуха,'){
$temp = $gmc[$i+4]; break;}}
for ($i=8; $i<50; $i++) { if ($gmc[$i] == 'Относительная' && $gmc[$i+1] == 'влажность,'){
$otnvlaz = $gmc[$i+4]; break;}}
for ($i=8; $i<100; $i++) { if ($gmc[$i] == 'Направление' && $gmc[$i+1] == 'ветра'){
$naprvetra = $gmc[$i+3]; break;}}
for ($i=8; $i<100; $i++) { if ($gmc[$i] == 'Скорость' && $gmc[$i+1] == 'ветра,'){
$scorvetra = $gmc[$i+4];  break;}}
for ($i=8; $i<100; $i++) { if ($gmc[$i] == 'общей' && $gmc[$i+1] == 'облачности'){
$balobl = $gmc[$i+3];  break;}}
for ($i=8; $i<100; $i++) { if ($gmc[$i] == 'видимость,' && $gmc[$i+1] == 'км'){
$gorvid = $gmc[$i+3];  break;}}
for ($i=8; $i<100; $i++) { if ($gmc[$i] == 'часа,' && $gmc[$i+1] == 'мм'){
$osad24 = $gmc[$i+3];  break;}}
for ($i=8; $i<100; $i++) { if ($gmc[$i] == 'часов,' && $gmc[$i+1] == 'мм'){
$osad12 = $gmc[$i+3];  break;}}
for ($i=8; $i<130; $i++) { if ($gmc[$i] == 'покрова,' && $gmc[$i+1] == 'см'){
echo $vyspok = $gmc[$i+3];  break;}}

}
//проверяем на наличие или создаём таблицу
 
$res = mysql_query ("CREATE TABLE IF NOT EXISTS $gorod  
( id  int(8)             NOT NULL AUTO_INCREMENT,
chas   int(4)          NOT NULL,
date             varchar(20)       NOT NULL, 
  atmdavlnaurst   int(8)             NOT NULL,
  temp           float(8)             NOT NULL,
  otnvlaz         int(8)             NOT NULL,
  naprvetra        varchar(8)             NOT NULL,
  scorvetra         int(8)             NOT NULL,
  balobl         int(8)             NOT NULL,
  gorvid         int(8)             NOT NULL,
  osad24          float             NOT NULL,
  osad12          float             NOT NULL,
  vyspok          int(8)             NOT NULL,
dd          varchar(20)            NOT NULL,
month          int(8)             NOT NULL,
day          int(8)             NOT NULL,
PRIMARY KEY (id)
 
)")or die("Error in sql: <br>$sql<br>".mysql_error());


$result = mysql_query ("INSERT INTO $gorod (date, chas,
atmdavlnaurst, temp, otnvlaz, naprvetra, scorvetra, balobl, gorvid, osad12, osad24, 
 vyspok, dd, month, day) 
 
 VALUES ('$date', '$chas',
 '$atmdavlnaurst', '$temp', '$otnvlaz', '$naprvetra', '$scorvetra', '$balobl', 
     '$gorvid', '$osad12', '$osad24', '$vyspok',
 '$dod', '$me', '$d')")or die("Error in sql: <br>$sql<br>".mysql_error());

   }

 }
 
 }
 */
 public static function getDatas($content, $tag_in, $tag_out) {
     if (strstr($content, $tag_in)) {
	
	$cutContent = str_replace('&deg;C', ' ',strip_tags(substr($content, strpos($content, $tag_in))));

	//$content = strip_tags($content);
	//$content = str_replace('&deg;C', ' ', $content);  
 
	while(strpos($content,'  ')!==false)  // удаляем последовательности пробелов
	    {
	      $content = str_replace('  ',' ',$content);
	    }; 
		$content = str_replace('  ', ' ', $content);  
		$content = str_replace('   ', ' ', $content);  
		$content = str_replace('Погода', '', $content); 
		$content = str_replace('Комментарий к погоде', '', $content); 
		$content = str_replace('Ливневой дождь слабый', '', $content);
		$content = str_replace('Количество облаков увеличилось', '', $content);
		$content = str_replace('Ливневый дождь', '', $content);
		$content = str_replace('Дымка (видимость больше 1 км)', '', $content);
		$content = str_replace('Ухудшение видимости из-за дыма или вулканического пепла', '', $content);
		$content = str_replace('Туман (видимость менее 1 км)', '', $content);
		$content = str_replace('Туман ослабел (небо не видно)', '', $content);
		$content = str_replace('Гроза слабая или умеренная (возможен дождь или снег)', '', $content);

		$content  = str_replace(chr(9),' ', $content);
		$content  = str_replace(chr(11),' ', $content);
		$content  = str_replace(chr(13),' ', $content);

		$gmc = explode(" ", $content);

		for ($i=0; $i<50; $i++) { if ($gmc[$i] == 'уровне' && $gmc[$i+1] == 'станции,'){
		$atmdavlnaurst = $gmc[$i+7]; break;}}
		for ($i=8; $i<50; $i++) { if ($gmc[$i] == 'Температура' && $gmc[$i+1] == 'воздуха,'){
		$temp = $gmc[$i+4]; break;}}
		for ($i=8; $i<50; $i++) { if ($gmc[$i] == 'Относительная' && $gmc[$i+1] == 'влажность,'){
		$otnvlaz = $gmc[$i+4]; break;}}
		for ($i=8; $i<100; $i++) { if ($gmc[$i] == 'Направление' && $gmc[$i+1] == 'ветра'){
		$naprvetra = $gmc[$i+3]; break;}}
		for ($i=8; $i<100; $i++) { if ($gmc[$i] == 'Скорость' && $gmc[$i+1] == 'ветра,'){
		$scorvetra = $gmc[$i+4];  break;}}
		for ($i=8; $i<100; $i++) { if ($gmc[$i] == 'общей' && $gmc[$i+1] == 'облачности'){
		$balobl = $gmc[$i+3];  break;}}
		for ($i=8; $i<100; $i++) { if ($gmc[$i] == 'видимость,' && $gmc[$i+1] == 'км'){
		$gorvid = $gmc[$i+3];  break;}}
		for ($i=8; $i<100; $i++) { if ($gmc[$i] == 'часа,' && $gmc[$i+1] == 'мм'){
		$osad24 = $gmc[$i+3];  break;}}
		for ($i=8; $i<100; $i++) { if ($gmc[$i] == 'часов,' && $gmc[$i+1] == 'мм'){
		$osad12 = $gmc[$i+3];  break;}}
		for ($i=8; $i<130; $i++) { if ($gmc[$i] == 'покрова,' && $gmc[$i+1] == 'см'){
		echo $vyspok = $gmc[$i+3];  break;}}

	    }
	}
 
    
}
        