<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pogodaxxi".
 *
 * @property integer $id
 * @property string $title
 * @property integer $year
 * @property integer $date
 * @property integer $month
 * @property integer $week
 * @property integer $day_week
 * @property string $prim
 */
class PogodaXXI extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pogodaxxi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'year', 'date', 'month', 'week', 'day_week', 'prim'], 'required'],
            [['year', 'date', 'month', 'week', 'day_week'], 'integer'],
            [['prim'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'year' => 'Year',
            'date' => 'Date',
            'month' => 'Month',
            'week' => 'Week',
            'day_week' => 'Day Week',
            'prim' => 'Prim',
        ];
    }
}
