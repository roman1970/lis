<?php

namespace app\models;

use app\components\TranslateHelper;
use Yii;

/**
 * This is the model class for table "theme".
 *
 * @property int $id
 * @property string $title
 * @property string $alias
 *
 * @property RadioThemeItems[] $themeItems
 */
class RadioTheme extends \yii\db\ActiveRecord
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
        return 'theme';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'alias'], 'string', 'max' => 255],
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
            'alias' => 'Alias',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThemeItems()
    {
        return $this->hasMany(RadioThemeItems::className(), ['theme_id' => 'id']);
    }

    public  function beforeSave($options = [])
    {

        if (parent::beforeSave(1)) {
            if ($this->isNewRecord) {
                
                if (empty($this->alias))
                    $this->alias = TranslateHelper::translit($this->title);

                return true;
            } else

                return true;
        } else
            return false;
    }
}
