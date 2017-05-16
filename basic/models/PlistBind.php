<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "play_lst_bind".
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $play_list_id
 *
 * @property Playlist $playList
 * @property Items $item
 */
class PlistBind extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'play_lst_bind';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'play_list_id'], 'required'],
            [['item_id', 'play_list_id'], 'integer'],
            [['play_list_id'], 'exist', 'skipOnError' => true, 'targetClass' => Playlist::className(), 'targetAttribute' => ['play_list_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Items::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'play_list_id' => 'Play List ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayList()
    {
        return $this->hasOne(Playlist::className(), ['id' => 'play_list_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Items::className(), ['id' => 'item_id']);
    }
}
