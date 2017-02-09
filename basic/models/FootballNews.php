<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "football_news".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $guid
 * @property string $link
 * @property string $pdalink
 * @property string $author
 * @property string $sections
 * @property string $tags
 * @property string $pud_date
 */
class FootballNews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'football_news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'guid', 'link', 'pdalink', 'author', 'sections', 'tags', 'pud_date'], 'required'],
            [['description'], 'string'],
            [['guid'], 'integer'],
            [['title', 'link', 'pdalink', 'author', 'sections', 'tags', 'pud_date'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'guid' => 'Guid',
            'link' => 'Link',
            'pdalink' => 'Pdalink',
            'author' => 'Author',
            'sections' => 'Sections',
            'tags' => 'Tags',
            'pud_date' => 'Pud Date',
        ];
    }
}
