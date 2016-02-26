<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visit".
 *
 * @property integer $id
 * @property string $time
 * @property string $ip
 */
class Visit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'visit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time'], 'safe'],
            [['ip'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time' => 'Time',
            'ip' => 'Ip',
        ];
    }

    public  function beforeSave($options = [])
    {

        if (parent::beforeSave(1)) {
            if ($this->isNewRecord) {
                $this->time = date('Y-m-d H:i:s');

                return true;
            } else

                return true;
        } else
            return false;
    }
}
