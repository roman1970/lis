<?php
namespace app\modules\diary\models;

use Yii;


class Ormon extends \yii\db\ActiveRecord
{
    

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ormon';
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