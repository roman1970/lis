<?php

namespace app\models;

use app\components\MoneyBehavior;
use Yii;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property string $name
 * @property integer $cat_id
 * @property string $price
 * @property string $photo
 * @property string $description
 *
 * @property Orders[] $orders
 * @property Categories[] $cat
 */
class Products extends \yii\db\ActiveRecord
{
    public $sum;
    public $cnt;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'cat_id', 'description', 'currency', 'currency_out'], 'required'],
            [['cat_id', 'currency', 'currency_out'], 'integer'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['name', 'photo'], 'string', 'max' => 255],
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
            'cat_id' => 'Cat ID',
            'price' => 'Price',
            'photo' => 'Photo',
            'description' => 'Description',
            'currency' => 'Валюта ввода',
            'currency_out' => 'Валюта вывода'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['prod_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(Categories::className(), ['id' => 'cat_id']);
    }

    public function behaviors()
    {
        return [
            'convertRubToRubCop' => [
                'class' => MoneyBehavior::className(),
                'money_in_rub' => 'price',
                'prop_out' => 'formatted_val',
                'currency_prop' => 'currency',
                'currency_out_prop' => 'currency_out'
            ]
        ];
    }
}
