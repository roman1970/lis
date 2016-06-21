<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tot_predict".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $date
 * @property integer $host_g
 * @property integer $guest_g
 * @property integer $match_id
 *
 * @property TotMatch $match
 * @property TotUser $user
 */
class Totpredict extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tot_predict';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'host_g', 'guest_g', 'match_id'], 'required'],
            [['user_id', 'host_g', 'guest_g', 'match_id'], 'integer'],
            [['date'], 'safe'],
            [['match_id'], 'exist', 'skipOnError' => true, 'targetClass' => TotMatch::className(), 'targetAttribute' => ['match_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => TotUser::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'date' => 'Date',
            'host_g' => 'Host G',
            'guest_g' => 'Guest G',
            'match_id' => 'Match ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatch()
    {
        return $this->hasOne(TotMatch::className(), ['id' => 'match_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(TotUser::className(), ['id' => 'user_id']);
    }
}
