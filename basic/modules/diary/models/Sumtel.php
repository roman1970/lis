<?php
namespace frontend\modules\diary\models;

use Yii;


class Sumtel extends \yii\db\ActiveRecord
{
    
    public static function getDb() {
         return Yii::$app->db_diary;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sum_tel';
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