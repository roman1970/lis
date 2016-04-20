<?php

namespace app\modules\currency\models;

use Yii;

/**
 * This is the model class for table "currencies".
 *
 * @property integer $id
 * @property string $name
 * @property string $valute_id
 * @property string $num_code
 * @property string $char_code
 *
 * @property CurrHistory[] $currHistories
 */
class Currencies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currencies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'valute_id', 'num_code', 'char_code'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['valute_id', 'num_code', 'char_code'], 'string', 'max' => 10],
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
            'valute_id' => 'Valute ID',
            'num_code' => 'Num Code',
            'char_code' => 'Char Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrHistories()
    {
        return $this->hasMany(CurrHistory::className(), ['currency_id' => 'id']);
    }
}
