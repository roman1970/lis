<?php
namespace app\modules\diary\models;

use Yii;


class Money extends \yii\db\ActiveRecord
{
    const STOIMOST_KILOVATA_ELEKTRICHESTVA = 2.09;
    const STOIMOST_KUBA_GOR_VODY = 92.39;
    const STOIMOST_KUBA_HOL_VODY = 23.78;
    

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'money';
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