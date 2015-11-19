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
                if($this->stra_h) {
                    $country = $this->getCountryCode($this->stra_h, $value);
                  //  var_dump($country);
                }
                else $country = "";
                echo  $value . '<img src="css/blank.gif" class="flag flag-'.$country.'" alt="" /><br />';
            }
        }
        else return false;


    }

    public function goalG_str()
    {
        if ($this->goul_g != '') {

            $exp_goalh = explode(",", $this->goul_g, -1);

            foreach ($exp_goalh as $value) {
                if($this->stra_g) {
                    $country = $this->getCountryCode($this->stra_g, $value);
                    //  var_dump($country);
                }
                else $country = "";
                echo '<img src="css/blank.gif" class="flag flag-'.$country.'" alt="" />'. $value . "<br />";
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

    public function substitH_str()
    {
        if ($this->substit_h != '') {


            $exp_substit = explode(",", $this->substit_h, -1);

            foreach ( $exp_substit as $value) {
                echo  $value . "(замена)<br />";
            }
        }

        else return false;


    }

    public function substitG_str()
    {
        if ($this->substit_g != '') {

            $exp_substit = explode(",", $this->substit_g, -1);

            foreach ($exp_substit as $value) {
                echo  $value . "(замена)<br />";
            }
        }

        else return false;


    }

    public function penMissH_str()
    {
        if ($this->pen_miss_h != '') {


            $exp_penmiss = explode(",", $this->pen_miss_h, -1);

            foreach ( $exp_penmiss as $value) {
                echo $value . "<br />";
            }
        }

        else return false;


    }

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