<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "incomes".
 *
 * @property integer $id
 * @property integer $income_id
 * @property integer $act_id
 * @property integer $user_id
 * @property string $money
 *
 * @property Income $income
 * @property DiaryActs $act
 * @property MarkUser $user
 */
class Incomes extends \yii\db\ActiveRecord
{
    public $cnt;
    public $sum;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'incomes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['income_id', 'act_id', 'user_id'], 'required'],
            [['income_id', 'act_id', 'user_id'], 'integer'],
            [['money'], 'number'],
            [['income_id'], 'exist', 'skipOnError' => true, 'targetClass' => Income::className(), 'targetAttribute' => ['income_id' => 'id']],
            [['act_id'], 'exist', 'skipOnError' => true, 'targetClass' => DiaryActs::className(), 'targetAttribute' => ['act_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => MarkUser::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'income_id' => 'Income ID',
            'act_id' => 'Act ID',
            'user_id' => 'User ID',
            'money' => 'Money',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncome()
    {
        return $this->hasOne(Income::className(), ['id' => 'income_id']);
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
    public function getUser()
    {
        return $this->hasOne(MarkUser::className(), ['id' => 'user_id']);
    }
}
