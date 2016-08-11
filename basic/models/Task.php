<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $status
 * @property integer $hour
 * @property integer $dead_line
 *
 * @property Tasked[] $taskeds
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'dead_line'], 'required'],
            [['status', 'hour', 'dead_line'], 'integer'],
            [['name', 'description'], 'string', 'max' => 255],
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
            'description' => 'Description',
            'status' => 'Status',
            'hour' => 'Hour',
            'dead_line' => 'Dead Line',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskeds()
    {
        return $this->hasMany(Tasked::className(), ['task_id' => 'id']);
    }
}
