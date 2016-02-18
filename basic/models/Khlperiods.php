<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chl_periods".
 *
 * @property integer $id
 * @property integer $match
 * @property integer $first
 * @property integer $second
 * @property integer $third
 * @property integer $overtime
 *
 * @property ChlMatches[] $chlMatches
 * @property ChlMatches[] $chlMatches0
 * @property ChlMatches[] $chlMatches1
 * @property ChlMatches[] $chlMatches2
 * @property ChlMatches[] $chlMatches3
 * @property ChlMatches[] $chlMatches4
 * @property ChlMatches[] $chlMatches5
 * @property ChlMatches[] $chlMatches6
 * @property ChlMatches[] $chlMatches7
 * @property ChlMatches[] $chlMatches8
 * @property ChlMatches[] $chlMatches9
 * @property ChlMatches[] $chlMatches10
 * @property ChlMatches[] $chlMatches11
 * @property ChlMatches[] $chlMatches12
 * @property ChlMatches[] $chlMatches13
 * @property ChlMatches[] $chlMatches14
 */
class Khlperiods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chl_periods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['match', 'first', 'second', 'third', 'overtime'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'match' => 'Match',
            'first' => 'First',
            'second' => 'Second',
            'third' => 'Third',
            'overtime' => 'Overtime',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChlMatches()
    {
        return $this->hasMany(Khlmatches::className(), ['facedown_vic_guest' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChlMatches0()
    {
        return $this->hasMany(Khlmatches::className(), ['penalty_time_guest' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChlMatches1()
    {
        return $this->hasMany(Khlmatches::className(), ['goals_in_more_host' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChlMatches2()
    {
        return $this->hasMany(Khlmatches::className(), ['goals_in_more_guest' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChlMatches3()
    {
        return $this->hasMany(Khlmatches::className(), ['goals_in_less_host' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChlMatches4()
    {
        return $this->hasMany(Khlmatches::className(), ['goals_in_less_guest' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChlMatches5()
    {
        return $this->hasMany(Khlmatches::className(), ['force_dodge_host' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChlMatches6()
    {
        return $this->hasMany(Khlmatches::className(), ['force_dodge_guest' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChlMatches7()
    {
        return $this->hasMany(Khlmatches::className(), ['facedown_vic_host' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChlMatches8()
    {
        return $this->hasMany(Khlmatches::className(), ['shot_in_goals_host' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChlMatches9()
    {
        return $this->hasMany(Khlmatches::className(), ['shot_in_goals_guest' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChlMatches10()
    {
        return $this->hasMany(Khlmatches::className(), ['shot_reflected_host' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChlMatches11()
    {
        return $this->hasMany(Khlmatches::className(), ['shot_reflected_guest' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChlMatches12()
    {
        return $this->hasMany(Khlmatches::className(), ['removal_host' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChlMatches13()
    {
        return $this->hasMany(Khlmatches::className(), ['removal_guest' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChlMatches14()
    {
        return $this->hasMany(Khlmatches::className(), ['penalty_time_host' => 'id']);
    }
}
