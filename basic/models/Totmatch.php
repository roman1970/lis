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
 * @property Matches $fooMatch
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
            [['foo_match_id'], 'exist', 'skipOnError' => true, 'targetClass' => Matches::className(), 'targetAttribute' => ['foo_match_id' => 'id']],
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
        return $this->hasOne(Matches::className(), ['id' => 'foo_match_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTotPredicts()
    {
        return $this->hasMany(TotPredict::className(), ['match_id' => 'id']);
    }

    /**
     * Преврашает дату таблицы matches в метку
     * @param $date
     * @return int
     */
    public static function formatMatchDateToTime($date){
        $d = explode('.', $date);
        $day = (int)$d[0];
        $month = (int)$d[1];
        $year = (int)$d[2];
        $time = mktime(0, 0, 0, $month, $day, $year);
        //$newDay = date('Y-m-d', $time);
        return $time;

    }

}
