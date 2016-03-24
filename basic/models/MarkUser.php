<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mark_user".
 *
 * @property integer $id
 * @property string $name
 *
 * @property MarkIt[] $markIts
 */
class MarkUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mark_user';
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
    public function getMarkIts()
    {
        return $this->hasMany(MarkIt::className(), ['user_id' => 'id']);
    }
}
