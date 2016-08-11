<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasked".
 *
 * @property integer $id
 * @property integer $task_id
 * @property integer $act_id
 * @property integer $user_id
 * @property integer $mark
 * @property integer $mark_status
 *
 * @property MarkUser $user
 * @property Task $task
 * @property ControllActs $act
 */
class Tasked extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tasked';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'act_id'], 'required'],
            [['task_id', 'act_id', 'user_id', 'mark', 'mark_status'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => MarkUser::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
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
            'task_id' => 'Task ID',
            'act_id' => 'Act ID',
            'user_id' => 'User ID',
            'mark' => 'Mark',
            'mark_status' => 'Mark Status',
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
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAct()
    {
        return $this->hasOne(DiaryActs::className(), ['id' => 'act_id']);
    }
}
