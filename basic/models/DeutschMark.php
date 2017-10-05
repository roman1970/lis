<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "deutsch_mark".
 *
 * @property int $id
 * @property int $user_id
 * @property string $mark
 *
 * @property MarkUser $user
 */
class DeutschMark extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deutsch_mark';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'mark'], 'required'],
            [['user_id'], 'integer'],
            [['mark'], 'string', 'max' => 255],
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
            'user_id' => 'User ID',
            'mark' => 'Mark',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(MarkUser::className(), ['id' => 'user_id']);
    }
}
