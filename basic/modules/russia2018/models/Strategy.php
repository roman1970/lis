<?php

namespace app\modules\russia2018\models;

use Yii;

class Strategy extends \yii\db\ActiveRecord
{
    public $limit;
    public $host;
    public $guest;
    public $bet;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'foo_matches';
    }


}