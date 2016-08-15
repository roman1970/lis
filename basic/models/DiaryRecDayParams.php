<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rec_day_param".
 *
 * @property integer $id
 * @property integer $day_param_id
 * @property integer $act_id
 * @property integer $user_id
 * @property string $value
 *
 * @property MarkUser $user
 * @property DayParams $dayParam
 * @property ControllActs $act
 */
class DiaryRecDayParams extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rec_day_param';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day_param_id', 'act_id', 'user_id'], 'required'],
            [['day_param_id', 'act_id', 'user_id'], 'integer'],
            [['value'], 'number'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => MarkUser::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['day_param_id'], 'exist', 'skipOnError' => true, 'targetClass' => DiaryDayParams::className(), 'targetAttribute' => ['day_param_id' => 'id']],
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
            'day_param_id' => 'Day Param ID',
            'act_id' => 'Act ID',
            'user_id' => 'User ID',
            'value' => 'Value',
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
    public function getDayParam()
    {
        return $this->hasOne(DiaryDayParams::className(), ['id' => 'day_param_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAct()
    {
        return $this->hasOne(DiaryActs::className(), ['id' => 'act_id']);
    }
}
