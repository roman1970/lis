<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "image_storage".
 *
 * @property integer $id
 * @property string $img
 * @property string $orig_tag
 * @property integer $cont_art_id
 *
 * @property QparticlesContent $contArt
 */
class ImageStorage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image_storage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['img', 'orig_tag', 'cont_art_id'], 'required'],
            [['cont_art_id'], 'integer'],
            [['img', 'orig_tag'], 'string', 'max' => 255],
            [['cont_art_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticlesContent::className(), 'targetAttribute' => ['cont_art_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'img' => 'Img',
            'orig_tag' => 'Orig Tag',
            'cont_art_id' => 'Cont Art ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContart()
    {
        return $this->hasOne(ArticlesContent::className(), ['id' => 'cont_art_id']);
    }
}
