<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "repertuar_item".
 *
 * @property int $id
 * @property int $item_reper_id
 * @property int $item_phrase_id
 */
class RepertuareItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'repertuar_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_reper_id', 'item_phrase_id'], 'required'],
            [['item_reper_id', 'item_phrase_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_reper_id' => 'Item Reper ID',
            'item_phrase_id' => 'Item Phrase ID',
        ];
    }
}
