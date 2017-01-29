<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test_answers".
 *
 * @property integer $id
 * @property string $body
 * @property integer $question_id
 * @property integer $true
 *
 * @property TestQuestions $question
 */
class TestAnswers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_answers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['body', 'question_id', 'true'], 'required'],
            [['question_id', 'true'], 'integer'],
            [['body'], 'string', 'max' => 255],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => TestQuestions::className(), 'targetAttribute' => ['question_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'body' => 'Текст ответа',
            'question_id' => 'Question ID',
            'true' => 'Верный 1',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(TestQuestions::className(), ['id' => 'question_id']);
    }
}
