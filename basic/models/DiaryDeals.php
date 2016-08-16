<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "deals".
 *
 * @property integer $id
 * @property string $name
 * @property integer $mark
 * @property integer $status
 *
 * @property DoneDeal[] $doneDeals
 */
class DiaryDeals extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deals';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['mark', 'status'], 'integer'],
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
            'mark' => 'Mark',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoneDeals()
    {
        return $this->hasMany(DiaryDoneDeal::className(), ['deal_id' => 'id']);
    }
}
