<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "weather".
 *
 * @property integer $id
 * @property datetime $date
 * @property integer $atmdavlnaurst
 * @property integer $temp
 * @property integer $otnvlaz
 * @property integer $scorvetra
 * @property integer $balobl
 * @property integer $gorvid
 * @property integer $osad24
 * @property integer $osad12
 * @property integer $vyspok
 * @property integer $dd
 * @property string $naprvetra
 * @property integer $city_id
 */
class Weather extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'weather';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id'], 'integer'],
           // [['name'], 'string', 'max' => 50]
        ];
    }

    public function getCity()
    {
        return $this->hasMany(City::className(), ['city_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            //'name' => 'Name',
           // 'id_parent' => 'Id Parent',
        ];
    }
}