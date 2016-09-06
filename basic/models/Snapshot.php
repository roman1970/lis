<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "day_snapshot".
 *
 * @property integer $id
 * @property string $date
 * @property string $weight
 * @property string $doll
 * @property string $euro
 * @property integer $oz
 * @property integer $mish_oz
 */
class Snapshot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'day_snapshot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['weight', 'doll', 'euro'], 'number'],
            [['oz', 'mish_oz'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'weight' => 'Weight',
            'doll' => 'Doll',
            'euro' => 'Euro',
            'oz' => 'Oz',
            'mish_oz' => 'Mish Oz',
        ];
    }

    public  function beforeSave($options = [])
    {

        if (parent::beforeSave(1)) {
            if ($this->isNewRecord) {
                $this->date = date('Y-m-d');

                return true;
            } else

                return true;
        } else
            return false;
    }
}
