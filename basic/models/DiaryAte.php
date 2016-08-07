<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ate".
 *
 * @property integer $id
 * @property integer $dish_id
 * @property integer $act_id
 * @property integer $measure
 * @property integer $kkal
 *
 * @property ControllActs $act
 * @property Dish $dish
 */
class DiaryAte extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dish_id', 'act_id', 'measure', 'kkal'], 'required'],
            [['dish_id', 'act_id', 'measure', 'kkal'], 'integer'],
            [['act_id'], 'exist', 'skipOnError' => true, 'targetClass' => DiaryActs::className(), 'targetAttribute' => ['act_id' => 'id']],
            [['dish_id'], 'exist', 'skipOnError' => true, 'targetClass' => DiaryDish::className(), 'targetAttribute' => ['dish_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dish_id' => 'Dish ID',
            'act_id' => 'Act ID',
            'measure' => 'Measure',
            'kkal' => 'Kkal',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAct()
    {
        return $this->hasOne(DiaryActs::className(), ['id' => 'act_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDish()
    {
        return $this->hasOne(DiaryDish::className(), ['id' => 'dish_id']);
    }
}
