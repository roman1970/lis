<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "done_deal".
 *
 * @property integer $id
 * @property integer $deal_id
 * @property integer $act_id
 * @property integer $user_id
 *
 * @property MarkUser $user
 * @property Deals $deal
 * @property ControllActs $act
 */
class DiaryDoneDeal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'done_deal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deal_id', 'act_id', 'user_id'], 'required'],
            [['deal_id', 'act_id', 'user_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => MarkUser::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['deal_id'], 'exist', 'skipOnError' => true, 'targetClass' => DiaryDeals::className(), 'targetAttribute' => ['deal_id' => 'id']],
            [['act_id'], 'exist', 'skipOnError' => true, 'targetClass' => DiaryActs::className(), 'targetAttribute' => ['act_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'deal_id' => 'Deal ID',
            'act_id' => 'Act ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(MarkUser::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeal()
    {
        return $this->hasOne(DiaryDeals::className(), ['id' => 'deal_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAct()
    {
        return $this->hasOne(DiaryActs::className(), ['id' => 'act_id']);
    }
}
