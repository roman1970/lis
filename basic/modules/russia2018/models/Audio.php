<?php

namespace app\modules\weather\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $id_parent
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