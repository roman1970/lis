<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "weathernew".
 *
 * @property integer $id
 * @property string $main
 * @property string $description
 * @property string $icon
 * @property string $temp
 * @property string $temp_min
 * @property string $temp_max
 * @property integer $pressure
 * @property integer $humidity
 * @property integer $visibility
 * @property integer $wind_speed
 * @property integer $wind_deg
 * @property integer $sea_level
 * @property integer $rain_3h
 * @property integer $grnd_level
 * @property integer $clouds
 * @property integer $time
 * @property integer $sunrise
 * @property integer $sunset
 * @property integer $res_code
 * @property integer $city_id
 *
 * @property Cities $city
 */
class Weathernew extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'weathernew';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['main', 'description', 'icon', 'pressure', 'humidity', 'visibility', 'wind_speed', 'wind_deg', 'sea_level', 'rain_3h', 'grnd_level', 'clouds', 'time', 'sunrise', 'sunset', 'res_code', 'city_id'], 'required'],
            [['temp', 'temp_min', 'temp_max'], 'number'],
            [['pressure', 'humidity', 'visibility', 'wind_speed', 'wind_deg', 'sea_level', 'rain_3h', 'grnd_level', 'clouds', 'time', 'sunrise', 'sunset', 'res_code', 'city_id'], 'integer'],
            [['main', 'description', 'icon'], 'string', 'max' => 255],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'main' => 'Main',
            'description' => 'Description',
            'icon' => 'Icon',
            'temp' => 'Temp',
            'temp_min' => 'Temp Min',
            'temp_max' => 'Temp Max',
            'pressure' => 'Pressure',
            'humidity' => 'Humidity',
            'visibility' => 'Visibility',
            'wind_speed' => 'Wind Speed',
            'wind_deg' => 'Wind Deg',
            'sea_level' => 'Sea Level',
            'rain_3h' => 'Rain 3h',
            'grnd_level' => 'Grnd Level',
            'clouds' => 'Clouds',
            'time' => 'Time',
            'sunrise' => 'Sunrise',
            'sunset' => 'Sunset',
            'res_code' => 'Res Code',
            'city_id' => 'City ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }
}
