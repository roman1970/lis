<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "country".
 *
 * @property integer $id
 * @property string $name
 * @property string $weather_link
 * @property integer $country_id
 */

class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
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
            'name' => 'Name',
        ];
    }
}
