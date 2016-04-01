<?php

namespace app\models;

use Faker\Provider\zh_TW\DateTime;
use Yii;

/**
 * This is the model class for table "mark_it".
 *
 * @property integer $id
 * @property string $date
 * @property string $ball
 * @property integer $user_id
 * @property integer $action_id
 *
 * @property MarkUser $user
 * @property MarkActions $action
 */
class MarkIt extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mark_it';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            //[['ball'], 'string'],
            ['ball', 'in','range'=>range(1,5)],
            [['user_id', 'action_id'], 'required'],
            [['user_id', 'action_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => MarkUser::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['action_id'], 'exist', 'skipOnError' => true, 'targetClass' => MarkActions::className(), 'targetAttribute' => ['action_id' => 'id']],
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
            'ball' => 'Ball',
            'user_id' => 'User ID',
            'action_id' => 'Action ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(MarkUser::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAction()
    {
        return $this->hasOne(MarkActions::className(), ['id' => 'action_id']);
    }

    /**
     * Берём среднюю оценку по дате и юзеру
     * @param $date
     * @param $user
     * @return bool|float
     */
    public static function getAverageForDateAndUser($date, $user)
    {

        $marks = self::find()
            ->where(['date' => $date, 'user_id' => $user])
            ->all();
        return self::getAverageMark($marks);

    }

    /**
     * Средний балл для юзера
     * @param $user
     * @return bool|float
     */
    public static function getAverageForUser($user){
        $marks = self::find()
            ->where(['user_id' => $user])
            ->all();

        return self::getAverageMark($marks);

    }

    /**
     * Средняя оценка за все время
     * @param $marks
     * @return bool|float
     */
    public static function getAverageMark($marks){
        if (count($marks)) {
            $sum = 0;
            foreach ($marks as $mark) {
                $sum += (int)$mark->ball;
            }
            return $sum / (count($marks));

        }
        return false;

    }

    public static function getThisGroupUsersAverageMark($group_id){
        $group_users = [];
        $group_actions = MarkActions::findAll(['group_id' => $group_id]);
        $id_actions = [];
        foreach ($group_actions as $act){
            $id_actions[] = $act->id;
        }

        $marks = self::find()
            ->where('action_id IN ('.implode(',',$id_actions).')')
            ->groupBy('user_id')
            ->all();
        //SELECT * FROM dates GROUP BY name;

        $leadsCount = self::find()
            ->select(['COUNT(*) AS cnt'])
            ->where('action_id IN ('.implode(',',$id_actions).')')
            ->groupBy('user_id')
            ->all();


        return var_dump($marks);

    }

}
