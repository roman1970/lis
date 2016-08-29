<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estest".
 *
 * @property integer $id
 * @property string $name
 * @property string $ideal
 * @property string $real
 * @property string $description
 * @property string $lim_val
 * @property integer $cat_id
 *
 * @property Qpcategory $cat
 */
class Estest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'ideal', 'real', 'cat_id'], 'required'],
            [['description'], 'string'],
            [['lim_val'], 'number'],
            [['cat_id'], 'integer'],
            [['name', 'ideal', 'real'], 'string', 'max' => 255],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['cat_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'ideal' => 'Ideal',
            'real' => 'Real',
            'description' => 'Description',
            'lim_val' => 'Lim Val',
            'cat_id' => 'Cat ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(Categories::className(), ['id' => 'cat_id']);
    }
}
