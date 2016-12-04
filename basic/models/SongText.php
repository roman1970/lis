<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "song_texts".
 *
 * @property integer $id
 * @property integer $source_id
 * @property string $title
 * @property string $text
 */
class SongText extends \yii\db\ActiveRecord
{
    public $source_title;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'song_texts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_id', 'title', 'text'], 'required'],
            [['source_id'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['source_id'], 'exist', 'skipOnError' => true, 'targetClass' => Source::className(), 'targetAttribute' => ['source_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source_id' => 'Source ID',
            'title' => 'Title',
            'text' => 'Text',
        ];
    }

    public function getSource()
    {
        return $this->hasOne(Source::className(), ['id' => 'source_id']);
    }
}
