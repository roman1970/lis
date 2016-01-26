<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "chl_players".
 *
 * @property integer $id
 * @property string $name
 * @property integer $team_id
 * @property integer $status
 */

class Khlplayers extends \yii\db\ActiveRecord
{
    const STATUS_GOALKEEPER = 1;
    const STATUS_DEFENDER = 2;
    const STATUS_ATAKER = 3;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chl_players';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50]
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