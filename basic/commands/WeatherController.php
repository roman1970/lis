<?php 

namespace app\commands;
use app\models\City;
use app\models\Country;
use Yii;
use yii\console\Controller;
use app\components\rbac\UserRoleRule;
use app\models\Cities;
use app\models\Weather;

class WeatherController extends Controller
{
    // Ветер
    public $wind_chill;
    public $wind_direction;
    public $wind_speed;

    // Атмосферные показатели
    public $humidity;
    public $visibility;
    public $pressure;

    // Время восхода и заката переводим в формат unix time
    public $sunrise;
    public $sunset;

    // Текущая температура воздуха и погода
    public $temp;
    public $condition_text;
    public $condition_code;

    // Прогноз погоды на 5 дней
    public $forecast;
    public $weather_type;

    public $units;

    private $cities;
    public $cityId;

    public $y;
    public $d;
    public $me;
    public $dod;
    public $chas;
    public $date;
    

   public function init()
   {
       echo "\r\n" . 'START...' . "\r\n\r\n";
       $this->y = date("Y");
       $this->d = date("d");
       $this->me = date("m");
       $this->dod = date("D");
       $this->chas = date("H");
       $this->date = date("Y-m-d H:i:s");
       $this->cities = [
            'Новосибирск',
            'Москва',
           'Красноярск',
           'Астрахань',
           'Горно-Алтайск',
           'Барнаул',
           'Уфа',
           'Махачкала',
           'Воронеж',
           'Волгоград',
           'Адлер',
           'Калининград',
           'Петропавловск-Камчатский',
           'Кемерово',
           'Магадан',
           'Мурманск',
           'Нижний Новгород',
           'Чулым',
           'Омск',
           'Владивосток',
           'Ростов-на-Дону',
           'Якутск',
           'Рязань',
           'Самара',
           'Екатеринбург',
           'Казань',
           'Томск',
           'Хабаровск',
           'Ханты-Мансийск',
           'Анадырь',
           'Ярославль'
       ];
       $cityUrls = [
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

   }
    public function __destruct()
    {
        echo "\r\n" . 'END.' . "\r\n\r\n";
    }

    /*
        Дефолтный экшен
    */
    public function actionIndex()
    {
        $methods = get_class_methods($this);
        echo 'Actions:' . "\r\n";
        foreach ($methods as $method)
            if (preg_match('/^action(.+)$/', $method, $match))
                echo ' - ' . $match[1] . "\r\n";
    }

    public function actionGetGMWeather() {
        $cities= Cities::findAll(['country_id' => 0]);
        //$customers = Customer::findAll(['age' => 30, 'status' => 1]);
        // var_dump($cities); exit;
        foreach($cities as $city) {
            echo $city->name;

            $ch = curl_init();
            $url = "$city->weather_link";
            curl_setopt($ch, CURLOPT_URL,$url);
            //curl_setopt($ch, CURLOPT_HEADER, 1); // читать заголовок
            //curl_setopt($ch, CURLOPT_NOBODY, 1); // читать ТОЛЬКО заголовок без тела
            $result = curl_exec($ch);
            curl_close($ch);
           // $content = file_get_contents($city->weather_link);
            $clearedDatas = $this->clearDatas($result, 'Атмосферное давление', ' ');
           // var_dump($clearedDatas); exit;
            $this->putDatasInTable($clearedDatas, $city);


        }

    }

    public function actionGetYHWeather($code='RSXX0063'){
        $cities= Cities::findAll(['country_id' => 0]);
        foreach($cities as $city) {

            if($city->yhcode) {
                $code = $city->yhcode;
                echo $city->name;
            }
            else continue;

            $units = 'c';
            $lang = 'en';

            $this->units = ($units == 'c') ? 'c' : 'f';

            $url = 'http://xml.weather.yahoo.com/forecastrss?p=' .
                $code . '&u=' . $this->units;

            $xml_contents = file_get_contents($url);
            if ($xml_contents === false)
                throw new Exception('Error loading ' . $url);

            $xml = new \SimpleXMLElement($xml_contents);

            // Ветер
            $tmp = $xml->xpath('/rss/channel/yweather:wind');
            if ($tmp === false) throw new Exception("Error parsing XML.");
            $tmp = $tmp[0];

            $this->wind_chill = (int)$tmp['chill'];
            $this->wind_direction = (int)$tmp['direction'];
            $this->wind_speed = (int)$tmp['speed'];

            // Атмосферные показатели
            $tmp = $xml->xpath('/rss/channel/yweather:atmosphere');
            if ($tmp === false) throw new Exception("Error parsing XML.");
            $tmp = $tmp[0];

            $this->humidity = (int)$tmp['humidity'];
            $this->visibility = (int)$tmp['visibility'];
            $this->pressure = (int)$tmp['pressure'];

            // Время восхода и заката переводим в формат unix time
            $tmp = $xml->xpath('/rss/channel/yweather:astronomy');
            if ($tmp === false) throw new Exception("Error parsing XML.");
            $tmp = $tmp[0];

            $this->sunrise = strtotime($tmp['sunrise']);
            $this->sunset = strtotime($tmp['sunset']);

            // Текущая температура воздуха и погода
            $tmp = $xml->xpath('/rss/channel/item/yweather:condition');
            if ($tmp === false) throw new Exception("Error parsing XML.");
            $tmp = $tmp[0];

            $this->temp = (int)$tmp['temp'];
            $this->condition_text = strtolower((string)$tmp['text']);
            $this->condition_code = (int)$tmp['code'];

            // Прогноз погоды на 5 дней
            $forecast = array();
            $tmp = $xml->xpath('/rss/channel/item/yweather:forecast');
            if ($tmp === false) throw new Exception("Error parsing XML.");

            foreach ($tmp as $day) {
                $this->forecast[] = array(
                    'date' => strtotime((string)$day['date']),
                    'low' => (int)$day['low'],
                    'high' => (int)$day['high'],
                    'text' => (string)$day['text'],
                    'code' => (int)$day['code']
                );
            }
            $this->putDatasInTableNew();
        }

    }

    public function actionGetYandexWeather(){
        foreach ($this->cities as $city) {
            $cityIn = City::findOne(['name' => $city]);

            $url =  'http://export.yandex.ru/weather-ng/forecasts/'.$cityIn->yndid.'.xml';
            //echo $url; exit;
            $xml = simplexml_load_file($url);
            $this->temp = $xml->fact->temperature;
            $this->weather_type = $xml->fact->weather_type;
            $this->wind_direction = $xml->fact->wind_direction;
            $this->wind_speed = $xml->fact->wind_speed;
            $this->humidity = $xml->fact->humidity;
            $this->pressure = $xml->fact->pressure;
            $this->cityId = $cityIn->id;

            $this->putDatasInTableNew();
        }

    }

    public function __toString() {
        $u = "°".(($this->units == 'c')?'C':'F');
        return $this->temp.' '.$u.', '.$this->condition_text;
    }

    
    /**
     * Создает таблицу
     * @param type $city
     * @return type
     */
    public static function  createTableAndPushIn($city){

       Yii::app()->db->createCommand("CREATE TABLE IF NOT EXISTS $city  (
	   id  int(8) NOT NULL AUTO_INCREMENT,
	   chas   int(4)          NOT NULL,
	   date   varchar(20)     NOT NULL, 
	   atmdavlnaurst   int(8) NOT NULL,
	   temp   float(8)        NOT NULL,
	   otnvlaz  int(8)        NOT NULL,
	   naprvetra  varchar(8)  NOT NULL,
	   scorvetra   int(8)     NOT NULL,
	   balobl   int(8)        NOT NULL,
	   gorvid     int(8)      NOT NULL,
	   osad24     float       NOT NULL,
	   osad12     float       NOT NULL,
	   vyspok     int(8)      NOT NULL,
	   dd      varchar(20)    NOT NULL,
	   month     int(8)       NOT NULL,
	   day     int(8)         NOT NULL,
	   PRIMARY KEY (id)
	       )")->execute(); 

       return;
   }


   /**
    * Готовим данные
    * @param string $content
    * @param string $tag_in
    * @param string $tag_out
    * @return array
    */
    public static function clearDatas($content, $tag_in, $tag_out) {


	if (strstr($content, $tag_in)) {

	    $content = str_replace('&deg;C', ' ',strip_tags(substr($content, strpos($content, $tag_in))));

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

		    return $gmc;

		}
		
	}

    /**
     * Помещаем данные в таблицу
     * @param array $gmc
     */
    public function putDatasInTable($gmc) {

        $pogoda = new Weather;
	    
	    $y = date("Y");
	    $d = date("d");
	    $me = date("m");
	    $dod = date("D");
	    $chas = date("H");
	    $date = date("d-m-Y");
	    $vyspok = 0;
	    $osad12 = 0;
	    $osad24 = 0;
	    $gorvid = 0;
	    $balobl = 0;
	    $scorvetra = 0;
	    $naprvetra = 0;
	    $otnvlaz = 0;
	    $temp = 0;
	    $atmdavlnaurst = 0;    

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
	    $vyspok = $gmc[$i+3];  break;}}

        $pogoda->chas = $chas;
        $pogoda->date = $date;
        $pogoda->atmdavlnaurst = $atmdavlnaurst;
        $pogoda->temp = $temp;
        $pogoda->otnvlaz = $otnvlaz;
        $pogoda->naprvetra = $naprvetra;
        $pogoda->scorvetra = $scorvetra;
        $pogoda->balobl = $balobl;
        $pogoda->gorvid = $gorvid;
        $pogoda->osad24 = $osad24;
        $pogoda->osad12 = $osad12;
        $pogoda->vyspok = $vyspok;
        $pogoda->dd = $d;
        $pogoda->save(false);


    }

    /**
     * Помещаем данные в таблицу
     * по новому
     */
    public function putDatasInTableNew() {



        $pogoda = new Weather;

        $pogoda->chas = $this->chas;
        $pogoda->date = $this->date;
        //var_dump($pogoda->date); exit;
        $pogoda->atmdavlnaurst = $this->pressure;
        $pogoda->temp = $this->temp;
        $pogoda->otnvlaz = $this->humidity;
        $pogoda->naprvetra = $this->wind_direction;
        $pogoda->scorvetra = $this->wind_speed;
        $pogoda->balobl = 0;
        $pogoda->gorvid = 0;
        $pogoda->osad24 = 0;
        $pogoda->osad12 = 0;
        $pogoda->vyspok = 0;
        $pogoda->dd = $this->d;
        $pogoda->city_id = $this->cityId;
        $pogoda->save(false);


    }

    public function actionGetCountriesFromYndex(){

        $url = "https://pogoda.yandex.ru/static/cities.xml";
        $dom = new \DomDocument();
        $dom->load($url);

        $countries = $dom->getElementsByTagName("country");

        foreach($countries as $country){
            $newCountry = new Country();
            $newCountry->name = $country->getAttribute('name');
            $newCountry->save(false);

        }

    }

    public function actionGetCitiesFromYndex(){
        set_time_limit(300);
        $url = "https://pogoda.yandex.ru/static/cities.xml";
        $dom = new \DomDocument();
        $dom->load($url);
        $cities = $dom->getElementsByTagName("city");


        foreach ($cities as $city) {
            $i=0;
            $country = $city->getAttribute('country');
            $countryIs = Country::findOne(['name' => $country]);

            if($countryIs) $country_id = $countryIs->id;
            else $country_id = 0;

            $cityNew = new City();

            $cityNew->yndid = $city->getAttribute('id');
            $cityNew->name = $city->textContent;
            $cityNew->part = $city->getAttribute('part');
            $cityNew->region = $city->getAttribute('region');
            $cityNew->country_id = $country_id;
            $cityNew->save(false);
            echo $i."  ".$cityNew->name;

        }


    }

    
}
        