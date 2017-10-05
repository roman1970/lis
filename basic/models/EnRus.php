<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "en_rus".
 *
 * @property int $id
 * @property string $en
 * @property string $rus
 */
class EnRus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'en_rus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['en', 'rus'], 'required'],
            [['en', 'rus'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'en' => 'En',
            'rus' => 'Rus',
        ];
    }
}
