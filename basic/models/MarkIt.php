<?php

namespace app\models;

use Faker\Provider\zh_TW\DateTime;
use Yii;

/**
 * This is the model class for table "mark_it".
 *
 * @property integer $id
 * @property string $date
 * @property string $ball
 * @property integer $user_id
 * @property integer $action_id
 *
 * @property MarkUser $user
 * @property MarkActions $action
 */
class MarkIt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mark_it';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            //[['ball'], 'string'],
            ['ball', 'in','range'=>range(1,5)],
            [['user_id', 'action_id'], 'required'],
            [['user_id', 'action_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => MarkUser::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['action_id'], 'exist', 'skipOnError' => true, 'targetClass' => MarkActions::className(), 'targetAttribute' => ['action_id' => 'id']],
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
            'ball' => 'Ball',
            'user_id' => 'User ID',
            'action_id' => 'Action ID',
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
    public function getAction()
    {
        return $this->hasOne(MarkActions::className(), ['id' => 'action_id']);
    }
}
