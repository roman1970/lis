<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "football_teams".
 *
 * @property integer $id
 * @property string $name
 * @property string $reg
 * @property string $adapt_name
 */
class Team extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'football_teams';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'reg', 'adapt_name'], 'required'],
            [['name', 'reg', 'adapt_name'], 'string', 'max' => 255],
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
            'reg' => 'Reg',
            'adapt_name' => 'Adapt Name',
        ];
    }
}
