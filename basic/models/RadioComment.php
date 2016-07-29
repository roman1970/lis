<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "radiocomments".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $body
 * @property string $d_created
 * @property string $status
 */
class RadioComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'radiocomments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'body'], 'required'],
            [['body', 'status'], 'string'],
            [['d_created'], 'safe'],
            [['name', 'email'], 'string', 'max' => 255],
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
            'email' => 'Email',
            'body' => 'Body',
            'd_created' => 'D Created',
            'status' => 'Status',
        ];
    }

    public  function beforeSave($options = [])
    {

        if (parent::beforeSave(1)) {
            if ($this->isNewRecord) {
                $this->d_created = date('Y-m-d H:i:s');

                return true;
            } else

                return true;
        } else
            return false;
    }
}
