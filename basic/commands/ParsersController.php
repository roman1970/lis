<?php
namespace app\commands;


use app\models\Currencies;
use app\models\CurrHistory;
use yii\console\Controller;
use Yii;
use app\components\Helper;
use app\components\TranslateHelper;


class ParsersController extends Controller
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
}