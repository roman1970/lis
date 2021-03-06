<?php

namespace app\modules\bardzilla\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $id_parent
 */
class Songs extends \yii\db\ActiveRecord
{
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
           // [['city_id'], 'integer'],
            // [['name'], 'string', 'max' => 50]
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            //'name' => 'Name',
            // 'id_parent' => 'Id Parent',
        ];
    }
}