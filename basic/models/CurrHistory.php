<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "curr_history".
 *
 * @property integer $id
 * @property string $date
 * @property integer $currency_id
 * @property integer $nominal
 * @property double $value
 *
 * @property Currencies $currency
 */
class CurrHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'curr_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['currency_id', 'value'], 'required'],
            [['currency_id', 'nominal'], 'integer'],
            [['value'], 'number'],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currencies::className(), 'targetAttribute' => ['currency_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'currency_id' => 'Currency ID',
            'nominal' => 'Nominal',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currencies::className(), ['id' => 'currency_id']);
    }
}
