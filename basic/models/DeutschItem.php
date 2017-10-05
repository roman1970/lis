<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "deutsch_item".
 *
 * @property int $id
 * @property string $d_word
 * @property string $d_phrase
 * @property string $d_word_translation
 * @property string $d_phrase_translation
 * @property string $d_word_transcription
 * @property string $d_phrase_transcription
 */
class DeutschItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deutsch_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['d_word',  'd_phrase', 'd_word_translation', 'd_phrase_translation', 'd_word_transcription', 'd_phrase_transcription', ], 'required'],
            [['d_word', 'd_phrase', 'd_word_translation', 'd_phrase_translation', 'd_word_transcription', 'd_phrase_transcription', ], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'd_word' => 'D Word',
            'd_phrase' => 'D Phrase',
            'd_word_translation' => 'D Word Translation',
            'd_phrase_translation' => 'D Phrase Translation',
            'd_word_transcription' => 'D Word Transcription',
            'd_phrase_transcription' => 'D Phrase Transcription',
        ];
    }
}
