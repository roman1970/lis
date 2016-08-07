<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dish".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $kkal
 *
 * @property Ate[] $ates
 */
class DiaryDish extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dish';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'kkal'], 'required'],
            [['kkal'], 'integer'],
            [['name', 'description'], 'string', 'max' => 255],
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
            'description' => 'Description',
            'kkal' => 'Kkal',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAtes()
    {
        return $this->hasMany(DiaryDish::className(), ['dish_id' => 'id']);
    }
}
