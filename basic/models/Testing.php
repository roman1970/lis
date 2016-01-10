<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "testing".
 *
 * @property integer $id
 * @property string $answer
 * @property string $question
 * @property integer $right
 * @property string $img
 */

class Testing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'testing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Вопрос',
        ];
    }
}
