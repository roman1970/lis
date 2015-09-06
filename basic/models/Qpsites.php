<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "qpsites".
 *
 * @property integer $id
 * @property string $title
 * @property integer $user_id
 * @property string $url
 * @property string $theme
 */
class Qpsites extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qpsites';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            // [['name'], 'string', 'max' => 50]
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        ];
    }
}