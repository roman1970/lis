<?php

namespace app\commands;

use app\models\City;
use app\models\Khlteams;
use app\models\Matches;
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


}