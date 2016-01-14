<?php
namespace frontend\modules\diary\models;

use Yii;


class Telbase extends \yii\db\ActiveRecord
{
    
    public static function getDb() {
         return Yii::$app->db_diary;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'telelephone';
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