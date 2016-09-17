<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test_klavaro".
 *
 * @property integer $id
 * @property string $presize
 * @property string $eng_ru
 * @property string $speed
 * @property integer $cat_id
 *
 * @property Categories $cat
 */
class Klavaro extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_klavaro';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['presize', 'speed'], 'number'],
            [['eng_ru', 'cat_id'], 'required'],
            [['cat_id'], 'integer'],
            [['eng_ru'], 'string', 'max' => 255],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['cat_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'presize' => 'Presize',
            'eng_ru' => 'Eng Ru',
            'speed' => 'Speed',
            'cat_id' => 'Cat ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(Categories::className(), ['id' => 'cat_id']);
    }
}
