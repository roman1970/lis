<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prod_user".
 *
 * @property integer $id
 * @property string $name
 * @property string $password
 * @property string $add
 *
 * @property Orders[] $orders
 */
class ProdUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prod_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'password', 'add'], 'required'],
            [['name', 'password', 'add'], 'string', 'max' => 255],
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
            'password' => 'Password',
            'add' => 'Add',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['user_id' => 'id']);
    }
}
