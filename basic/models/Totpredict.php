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
 * @property integer $status
 *
 * @property Totmatch $match
 * @property Totuser $user
 */
class Totpredict extends \yii\db\ActiveRecord
{

    public $sum;
    public $cnt;
    public $cnt_good;
    public $cnt_middle;
    public $cnt_bad;

    const STATUS_NON_TESTED = 0;
    const STATUS_BAD_PROGNOSE = 1;
    const STATUS_RIGHT_RESULT = 2;
    const STATUS_RIGHT_SCORE = 3;

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
            [['user_id', 'host_g', 'guest_g', 'match_id', 'status'], 'integer'],
            [['date'], 'safe'],
            [['match_id'], 'exist', 'skipOnError' => true, 'targetClass' => Totmatch::className(), 'targetAttribute' => ['match_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Totuser::className(), 'targetAttribute' => ['user_id' => 'id']],
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
        return $this->hasOne(Totmatch::className(), ['id' => 'match_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Totuser::className(), ['id' => 'user_id']);
    }

    public  function beforeSave($options = [])
    {

        if (parent::beforeSave(1)) {
            if ($this->isNewRecord) {
                $this->date = date('Y-m-d H:i:s');

                return true;
            } else

                return true;
        } else
            return false;
    }

    /**
     * Баланс по ставкам каждого юзера
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getUsersBalls(){
        $user_balls = self::find()
            ->select(['user_id, COUNT(*) as cnt, SUM(bet_balance) as sum '])
            ->groupBy('user_id')
            ->all();

        return $user_balls;
    }

    /**
     * Кешим в таблицу данные по каждому юзеру
     * @return bool
     * @throws \Exception
     */
    public static function getUsersStatus(){
        /*
        $zero_object = new Totpredict();
        $zero_object->cnt = 0;

        $users_status['bad'] = self::find()
            ->select(['user_id, status, COUNT(status) as cnt'])
            ->where(['status' => 1])
            ->groupBy('user_id')
            ->all();
        //var_dump($users_status); exit;
        $users_status['middle'] = self::find()
            ->select(['user_id, status, COUNT(status) as cnt'])
            ->where(['status' => 2])
            ->groupBy('user_id')
            ->all();
        $users_status['good'] = self::find()
            ->select(['user_id, status, COUNT(status) as cnt'])
            ->where(['status' => 3])
            ->groupBy('user_id')
            ->all();
        if(!isset($users_status['bad'])) $users_status['bad'] = $zero_object;
        if(!isset($users_status['middle'])) $users_status['middle'] = $zero_object;
        if(!isset($users_status['good'])) $users_status['good'] = $zero_object;
        */

        $users = Totuser::find()->all();
        
        if(!$users) return false;

        foreach ($users as $user){

            $user->balance = self::find()
                ->select(['SUM(bet_balance)'])
                ->where(['user_id' => $user->id])
                ->scalar();

            $user->no_goal = self::find()
                ->select(['COUNT(status) as cnt'])
                ->where(['user_id' => $user->id, 'status' => 1])
                ->scalar();


            $user->result = self::find()
                ->select(['COUNT(status) as cnt'])
                ->where(['user_id' => $user->id, 'status' => 2])
                ->scalar();


            $user->precise = self::find()
                ->select(['COUNT(status) as cnt'])
                ->where(['user_id' => $user->id, 'status' => 3])
                ->scalar();
            $user->update();

        }



        return true;
    }




}
