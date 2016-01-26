<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "chl_events".
 *
 * @property integer $id
 * @property integer $minute
 * @property integer $player_id
 * @property integer $match_id
 */

class Khlevents extends \yii\db\ActiveRecord
{
    const STATUS_GOAL = 1; // гол





    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chl_events';
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
            'id' => 'ID',

        ];
    }
}