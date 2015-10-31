<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "foo_matches".
 *
 */

class Matches extends \yii\db\ActiveRecord
{

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
                echo $value . "<br />";
            }
        }
        else return false;


    }

    public function goalG_str()
    {
        if ($this->goul_g != '') {

            $exp_goalh = explode(",", $this->goul_g, -1);

            foreach ($exp_goalh as $value) {
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
}