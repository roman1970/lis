<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test_questions".
 *
 * @property integer $id
 * @property string $body
 *
 * @property TestAnswers[] $testAnswers
 */
class TestQuestions extends \yii\db\ActiveRecord
{
    public $cat_title;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_questions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['body'], 'required'],
            [['body'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'body' => 'Текст вопроса',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(TestAnswers::className(), ['question_id' => 'id']);
    }
}
