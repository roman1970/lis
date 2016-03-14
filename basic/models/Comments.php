<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "qpcomments".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $body
 * @property string $d_created
 * @property integer $article_content_id
 * @property string $status
 *
 * @property articlesContent $articleContent
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qpcomments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'body', 'article_content_id'], 'required'],
            [['body', 'status'], 'string'],
            [['d_created'], 'safe'],
            [['article_content_id'], 'integer'],
            [['name', 'email'], 'string', 'max' => 255],
            [['article_content_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticlesContent::className(), 'targetAttribute' => ['article_content_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Ваше Имя',
            'email' => 'Email',
            'body' => 'Комментарий',
            'd_created' => 'D Created',
            'article_content_id' => 'Article Content ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleContent()
    {
        return $this->hasOne(ArticlesContent::className(), ['id' => 'article_content_id']);
    }

    public  function beforeSave($options = [])
    {

        if (parent::beforeSave(1)) {
            if ($this->isNewRecord) {
                $this->d_created = date('Y-m-d H:i:s');

                return true;
            } else

                return true;
        } else
            return false;
    }
}
