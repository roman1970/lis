<?php
namespace app\modules\diary\models;

use Yii;


class Sumtel extends \yii\db\ActiveRecord
{

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