<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "foo_team".
 *
 * @property integer $id
 * @property string $name
 * @property integer $tournament_id
 * @property integer $mem
 * @property integer $play
 * @property integer $vic
 * @property integer $nob
 * @property integer $def
 * @property integer $goal_g
 * @property integer $goal_l
 * @property integer $balls
 *
 * @property FooTournament $tournament
 */
class TeamSum extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'foo_team';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'tournament_id', 'mem', 'play', 'vic', 'nob', 'def', 'goal_g', 'goal_l', 'balls'], 'required'],
            [['tournament_id', 'mem', 'play', 'vic', 'nob', 'def', 'goal_g', 'goal_l', 'balls'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['tournament_id'], 'exist', 'skipOnError' => true, 'targetClass' => FooTournament::className(), 'targetAttribute' => ['tournament_id' => 'id']],
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
            'tournament_id' => 'Tournament ID',
            'mem' => 'Mem',
            'play' => 'Play',
            'vic' => 'Vic',
            'nob' => 'Nob',
            'def' => 'Def',
            'goal_g' => 'Goal G',
            'goal_l' => 'Goal L',
            'balls' => 'Balls',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTournament()
    {
        return $this->hasOne(Tournament::className(), ['id' => 'tournament_id']);
    }
}
