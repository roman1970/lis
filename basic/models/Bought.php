<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bought".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $act_id
 * @property integer $shop_id
 * @property integer $user_id
 * @property string $spent
 * @property string $item_price
 *
 * @property MarkUser $user
 * @property Products $product
 * @property ControllActs $act
 * @property Shop $shop
 */
class Bought extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bought';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'act_id', 'shop_id', 'user_id'], 'required'],
            [['product_id', 'act_id', 'shop_id', 'user_id'], 'integer'],
            [['spent', 'item_price'], 'number'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => MarkUser::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['act_id'], 'exist', 'skipOnError' => true, 'targetClass' => DiaryActs::className(), 'targetAttribute' => ['act_id' => 'id']],
            [['shop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shop::className(), 'targetAttribute' => ['shop_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'act_id' => 'Act ID',
            'shop_id' => 'Shop ID',
            'user_id' => 'User ID',
            'spent' => 'Spent',
            'item_price' => 'Item Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(MarkUser::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAct()
    {
        return $this->hasOne(DiaryActs::className(), ['id' => 'act_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }
}
