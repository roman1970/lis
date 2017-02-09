<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag_prods".
 *
 * @property integer $id
 * @property string $prod
 */
class TagProds extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag_prods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prod'], 'required'],
            [['prod'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prod' => 'Prod',
        ];
    }
}
