<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Country;
use yii\helpers\Url;

/**
 * This is the model class for table "foo_matches".
 *
 */

class Matches extends \yii\db\ActiveRecord
{
    public $events_h;
    public $events_g;
    public $cnt;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'foo_matches';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

        ];
    }

    public function goalH_str()
    {
        if ($this->goul_h != '') {

            $exp_goalh = explode(",", $this->goul_h, -1);

            foreach ($exp_goalh as $value) {
               /* if($this->stra_h) {
                    $country = $this->getCountryCode($this->stra_h, $value);
                  //  var_dump($country);
                }
                else $country = "";
               */
                echo  $value . "<br />";
            }
        }
        else return false;


    }

    public function goalG_str()
    {
        if ($this->goul_g != '') {

            $exp_goalh = explode(",", $this->goul_g, -1);

            foreach ($exp_goalh as $value) {
                /*
                if($this->stra_g) {
                    $country = $this->getCountryCode($this->stra_g, $value);
                    //  var_dump($country);
                }
                else $country = "";
                */
                echo $value . "<br />";
            }
        }
        else return false;


    }

    public function redCardH_str()
    {
        if ($this->red_kart_h != '') {


            $exp_rcard = explode(",", $this->red_kart_h, -1);

            foreach ($exp_rcard as $value) {
                echo "<img src='themes/russia2018/images/redcard.png' /> " . $value . "<br />";
            }
        }

        else return false;


    }

    public function redCardG_str()
    {
        if ($this->red_kart_g != '') {

            $exp_rcard = explode(",", $this->red_kart_g, -1);

            foreach ($exp_rcard as $value) {
                echo "<img src='themes/russia2018/images/redcard.png' /> " . $value . "<br />";
            }
        }

        else return false;


    }

    public function yellCardCount_h() {
        if ($this->yel_kart_h != '') {

            $exp_ycard = explode(",", $this->yel_kart_h, -1);

            foreach ($exp_ycard as $value) {
                echo " <img src='themes/russia2018/images/yellcard.png' /> ";
            }
        }

        else return false;

    }

    public function yellCardCount_g() {

        if ($this->yel_kart_g != '') {

            $exp_ycard = explode(",", $this->yel_kart_g, -1);

            foreach ($exp_ycard as $value) {
                echo " <img src='themes/russia2018/images/yellcard.png' /> ";
            }
        }

        else return false;

    }

    /**
     * Замены хозяев
     * @return bool
     */
    public function substitH_str()
    {
        if ($this->substit_h != '') {


            $exp_substit = explode(",", $this->substit_h, -1);

            foreach ( $exp_substit as $value) {
                $value = str_replace('.', '. ', $value);
                echo  $value . "<br>--------<br>";
            }
        }

        else return false;


    }

    /**
     * Замены гостей
     * @return bool
     */
    public function substitG_str()
    {
        if ($this->substit_g != '') {

            $exp_substit = explode(",", $this->substit_g, -1);

            foreach ($exp_substit as $value) {
                $value = str_replace('.', '. ', $value);
                echo  $value . "<br>--------<br>";
            }
        }

        else return false;


    }

    /**
     * Нереализованный пенальти хозяев
     * @return bool
     */
    public function penMissH_str()
    {
        if ($this->pen_miss_h != '') {


            $exp_penmiss = explode(",", $this->pen_miss_h, -1);

            foreach ( $exp_penmiss as $value) {
                echo $value . "<br>";
            }
        }

        else return false;


    }

    /**
     * Нереализованные пенальти гостей
     * @return bool
     */
    public function penMissG_str()
    {
        if ($this->pen_miss_g != '') {

            $exp_penmiss = explode(",", $this->pen_miss_g, -1);

            foreach ($exp_penmiss as $value) {
                echo $value . "<br />";
            }
        }

        else return false;


    }

    /**
     * Фильтруем и выводим состав хозяев
     */
    public function getSost_h(){
        if($this->stra_h != ''){
            $sost = '';
            $i = 0;
            $sost_arr = explode(',', $this->stra_h);

            while($i < 11){
                if(isset($sost_arr[$i])) $sost .= $sost_arr[$i];
                $i++;
            }

            echo self::clearString($sost);

        }
        else echo '?';

    }

    /**
     * Фильтруем и выводим состав гостей
     */
    public function getSost_g(){
        if($this->stra_g != ''){
            $sost = '';
            $i = 0;
            $sost_arr = explode(',', $this->stra_g);

            while($i < 11){
                if(isset($sost_arr[$i])) $sost .= $sost_arr[$i];
                $i++;
            }

            echo self::clearString($sost);

        }
        else echo '?';

    }

    /**
     * Информация о матче
     */
    public function getInfo(){
        if($this->info != ''){
            $res = $this->info;
            $res = str_replace('Стадион:', '<br>Стадион:', $res);
            $res = str_replace('Судья:', '<br>Судья:', $res);
            $res = str_replace('Посещаемость:', '<br>Посещаемость:', $res);
            echo $res;
        }
        else echo '';
    }

    /**
     * Оставляем буквы и кое-какие знаки в строке
     * @param $string
     * @return mixed
     */
    public static function clearString($string){

        $string = preg_replace("/-/", "- ", $string);

        return  preg_replace("/[^-а-яёА-ЯЁa-zA-Z.() ]+/iu", "", $string);
    }




    /**
     * Все события матча у хоэяев
     */
    public function allMatchEventsH(){
        $this->events_h = explode(',',$this->goalH_str().$this->penMissH_str().$this->redCardH_str().$this->substitH_str());
        $this->events_h = sort($this->events_h);
        var_dump($this->events_h);
        /*foreach ($this->events_h as $value) {
            echo $value . "<br />";
        }
        */

    }

    /**
     * Все события матча у гостей
     */
    public function allMatchEventsG(){

        $this->events_g = explode(',',$this->goalG_str().$this->penMissG_str().$this->redCardG_str().$this->substitG_str());
        $this->events_g = sort($this->events_g, SORT_REGULAR);
        echo $this->events_g;
        /*
        foreach ($this->events_g as $value) {
            echo $value . "<br />";
        }
        */

    }

    /**
     * Тренер хозяев
     * "TODO +couch[2]
     */
    public function getCoachH(){

        if ($this->stra_h != '') {

            $players = explode(',', $this->stra_h);

            $couch = explode('-', $players[count($players) - 2]);

            if (preg_match('/\d/', $couch[1])) {
                    return false;

            }
            else  return trim($couch[1]);
        }

        else return false;

    }

    /**
     * Тренер гостей
     */
    public function getCoachG(){

        if ($this->stra_g != '') {

            $players = explode(',', $this->stra_g);

            $couch = explode('-', $players[count($players) - 2]);

            if (preg_match('/\d/', $couch[1])) {
                return false;

            }
            else  return trim($couch[1]);

        }
        else return false;

    }

    /**
     * Вратарь хозяев
     */
    public function getKeeperH(){
        if ($this->stra_h != '') {

            $players = explode(',', $this->stra_h);
            foreach ($players as $player) {
                if(preg_match('/\(В\)/',$player)) {
                    $keeper = preg_replace ("/[0-9\-]/","",$player);
                    $keeper = preg_replace ("/\(В\)/","", $keeper);
                    return $keeper;
                }

            }
        }

    }

    /**
     * Вратарь гостей
     */
    public function getKeeperG(){
        if ($this->stra_g != '') {

            $players = explode(',', $this->stra_g);
            foreach ($players as $player) {
                if(preg_match('/\(В\)/',$player)) {
                    $keeper = preg_replace ("/[0-9\-]/","",$player);
                    $keeper = preg_replace ("/\(В\)/","", $keeper);
                    return $keeper;
                }

            }
        }

    }

    /**
     * Возвращает iso код страны игрока
     * @param string $players
     * @return mixed
     */
    public function getCountryCode($players, $player){
        $players = explode(',', $players);
        //$player = preg_replace ("/[0-9\']/","",$player);
        /*$player = explode(" ", $player);
        //trim($player);
        $new_player = "";
        foreach($player as $part) {
            if(!preg_match("/[\(\)]/",$part)) $new_player .= $part;
        }
        //trim($new_player);
        var_dump($new_player);*/
        foreach($players as $one) {

            if (strstr($one,substr($player,3)) || strstr($one,substr($player,4))) {
                $country_code = explode('-', $one);

                $country = Country::find()
                   ->where(['soccer_code' => (int)$country_code[0]])
                   ->one();

                return $country->iso_code;
            }

        }
        return null;
    }



}