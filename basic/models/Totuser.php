<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tot_user".
 *
 * @property integer $id
 * @property string $name
 * @property string $pseudo
 * @property string $money
 *
 * @property TotPredict[] $totPredicts
 */
class Totuser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tot_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'pseudo'], 'required'],
            [['money'], 'number'],
            [['name', 'pseudo'], 'string', 'max' => 255],
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
            'pseudo' => 'Pseudo',
            'money' => 'Money',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTotPredicts()
    {
        return $this->hasMany(TotPredict::className(), ['user_id' => 'id']);
    }
}
