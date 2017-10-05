<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "items".
 *
 * @property integer $id
 * @property integer $source_id
 * @property string $text
 * @property string $tags
 * @property string $audio
 *
 * @property Sources $source
 */
class Items extends \yii\db\ActiveRecord
{
    public $current_playlist = 0;
    public $source_title;
    public $cat_title;
    public $phrase;
    public $phrase2;
    
    const PLAYLIST_PLUS_6 = 1;
    const PLAYLIST_PLUS_12 = 2;
    const PLAYLIST_PLUS_18 = 3;
    const PLAYLIST_LIRIC = 4;
    
    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_id', 'text', 'tags', 'audio'], 'required'],
            [['source_id', 'text', 'tags', 'audio', 'cens'], 'save'],
            [['source_id'], 'integer'],
            [['text'], 'string'],
            [['tags', 'audio'], 'string', 'max' => 255],
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
            'text' => 'Text',
            'tags' => 'Tags',
            'audio' => 'Audio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(Source::className(), ['id' => 'source_id']);
    }

    public function getCat()
    {
        return $this->hasOne(Categories::className(), ['id' => 'cat_id']);
    }

    public function getOriginal()
    {
        return $this->hasOne(SongText::className(), ['id' => 'original_song_id']);
    }
}
