<?php
namespace frontend\modules\diary\models;

use Yii;


class Maner extends \yii\db\ActiveRecord
{
    
    public static function getDb() {
         return Yii::$app->db_diary;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'maner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
           
        ];
    }
}