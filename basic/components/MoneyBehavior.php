<?php
namespace app\components;

use app\modules\currency\models\Currencies;
use app\modules\currency\models\CurrHistory;
use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class MoneyBehavior extends Behavior
{
    public $money_in_rub;
    public $prop_out;
    public $currency_prop;
    public $currency_out_prop;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'setChangedMoney'
        ];
    }

    public function setChangedMoney($event)
    {

        if($this->owner->{$this->currency_prop} == 35){

            $curs = CurrHistory::find()->where(['currency_id' => $this->owner->{$this->currency_out_prop}])->all();

            $value = round($this->owner->{$this->money_in_rub}/$curs[0]->value/$curs[0]->nominal, 3, PHP_ROUND_HALF_EVEN);


        }
        else{
            $curs_in = CurrHistory::find()->where(['currency_id' => $this->owner->{$this->currency_prop}])->all();
            $curs_out = CurrHistory::find()->where(['currency_id' => $this->owner->{$this->currency_out_prop}])->all();

            $value = round(($this->owner->{$this->money_in_rub}*($curs_out[0]->value/$curs_out[0]->nominal))
                /($curs_in[0]->value/$curs_in[0]->nominal), 3, PHP_ROUND_HALF_EVEN);

        }

        $this->makeAndSetInHumanUnderstoodView($value);



    }

    public function makeAndSetInHumanUnderstoodView($value){

        $rub_cop = explode('.',  $value);

        $this->owner->{$this->prop_out} = $rub_cop[0] .' '.
            Currencies::findOne($this->owner->{$this->currency_out_prop})->name .' '. $rub_cop[1]. ' c ';


    }
}