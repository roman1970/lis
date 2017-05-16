<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "songs"
 *
 */
class RadioSongs extends \yii\db\ActiveRecord
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
        return 'songs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_id', 'title', 'text', 'link'], 'required'],
            [['source_id'], 'default', 'value' => null],
            [['source_id'], 'integer'],
            [['text'], 'string'],
            [['title', 'link'], 'string', 'max' => 255],
            [['source_id'], 'exist', 'skipOnError' => true, 'targetClass' => RadioSource::className(), 'targetAttribute' => ['source_id' => 'id']],
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
            'link' => 'Link',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(RadioSource::className(), ['id' => 'source_id']);
    }


}