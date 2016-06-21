<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tot_match".
 *
 * @property integer $id
 * @property string $date
 * @property string $host
 * @property string $guest
 * @property string $tournament
 * @property integer $foo_match_id
 *
 * @property FooMatches $fooMatch
 * @property TotPredict[] $totPredicts
 */
class Totmatch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tot_match';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'host', 'guest', 'tournament', 'foo_match_id'], 'required'],
            [['foo_match_id'], 'integer'],
            [['date', 'host', 'guest', 'tournament'], 'string', 'max' => 255],
            [['foo_match_id'], 'exist', 'skipOnError' => true, 'targetClass' => FooMatches::className(), 'targetAttribute' => ['foo_match_id' => 'id']],
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
            'host' => 'Host',
            'guest' => 'Guest',
            'tournament' => 'Tournament',
            'foo_match_id' => 'Foo Match ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFooMatch()
    {
        return $this->hasOne(FooMatches::className(), ['id' => 'foo_match_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTotPredicts()
    {
        return $this->hasMany(TotPredict::className(), ['match_id' => 'id']);
    }
}
