<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "chl_matches".
 *
 * @property integer $id
 * @property integer $host_id
 * @property integer $guest_id
 * @property integer $host_g
 * @property integer $guest_g
 * @property string $prim
 */

class Khlmatches extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chl_matches';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prim'], 'string', 'max' => 50]
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

    /**
     * Получаем имя команды-хозяина
     * @return \yii\db\ActiveQuery
     */
    public function getHost()
    {
        return $this->hasOne(Khlteams::className(), ['id' => 'host_id']);
    }

    /**
     * Получаем имя команды-гостя
     * @return \yii\db\ActiveQuery
     */
    public function getGuest()
    {
        return $this->hasOne(Khlteams::className(), ['id' => 'guest_id']);
    }
}
