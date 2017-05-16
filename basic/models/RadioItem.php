<?php

namespace app\models;

use app\components\TranslateHelper;
use Yii;

/**
 * This is the model class for table "items".
 *
 * @property int $id
 * @property int $cat_id
 * @property string $text
 * @property string $tags
 * @property string $audio
 * @property string $img
 * @property int $cens
 * @property int $published
 *
 * @property Category $cat
 */
class RadioItem extends \yii\db\ActiveRecord
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
        return 'items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'text', 'tags', 'audio', 'img', 'cens'], 'required'],
            [['cat_id', 'cens', 'published'], 'default', 'value' => null],
            [['cat_id', 'cens', 'published'], 'integer'],
            [['text'], 'string'],
            [['tags', 'audio', 'img'], 'string', 'max' => 255],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['cat_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => 'Cat ID',
            'text' => 'Text',
            'tags' => 'Tags',
            'audio' => 'Audio',
            'img' => 'Img',
            'cens' => 'Cens',
            'published' => 'Published',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(Category::className(), ['id' => 'cat_id']);
    }
    

    public  function beforeSave($options = [])
    {

        if (parent::beforeSave(1)) {
            if ($this->isNewRecord) {
                $this->d_created = date('Y-m-d H:i:s');
                if (empty($this->alias))
                    $this->alias = TranslateHelper::translit($this->title);

                return true;
            } else

                return true;
        } else
            return false;
    }
}
