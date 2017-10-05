<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "deutsch_tournament".
 *
 * @property int $id
 * @property int $user_id
 * @property string $mark
 * @property int $time
 *
 * @property MarkUser $user
 */
class DeutschTournament extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deutsch_tournament';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'mark', 'time'], 'required'],
            [['user_id', 'time'], 'integer'],
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
            'time' => 'Time',
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
