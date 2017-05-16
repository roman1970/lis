<?php

namespace app\models;

use app\components\TranslateHelper;
use Yii;

/**
 * This is the model class for table "author".
 *
 * @property int $id
 * @property string $name
 * 
 */
class RadioAuthor extends \yii\db\ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->get('db_postgres');
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'author';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
        ];
    }

   
}