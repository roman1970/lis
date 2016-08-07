<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "act_model".
 *
 * @property integer $id
 * @property string $name
 *
 * @property DiaryActs[] $controllActs
 */
class DiaryActModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'act_model';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getControllActs()
    {
        return $this->hasMany(DiaryActs::className(), ['model_id' => 'id']);
    }
}
