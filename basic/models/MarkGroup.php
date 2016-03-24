<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mark_group".
 *
 * @property integer $id
 * @property string $name
 *
 * @property MarkActions[] $markActions
 */
class MarkGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mark_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarkActions()
    {
        return $this->hasMany(MarkActions::className(), ['group_id' => 'id']);
    }
}
