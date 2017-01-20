<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "idea".
 *
 * @property integer $id
 * @property string $items
 * @property string $text
 */
class Idea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'idea';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['items', 'text'], 'required'],
            [['text'], 'string'],
            [['items'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'items' => 'Items',
            'text' => 'Text',
        ];
    }
}
