<?php
namespace app\components;

use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class MoneyBehavior extends Behavior
{
    //public $in_attribute = 'name';
    public $prop = 'formatted_val';
    //public $translit = true;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'setChangedMoney'
        ];
    }

    public function setChangedMoney($event)
    {

            $this->owner->{$this->prop} = 'kkk' ;


    }
}