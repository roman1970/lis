<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "controll_acts".
 *
 * @property integer $id
 * @property integer $time
 * @property integer $model_id
 *
 * @property Ate[] $ates
 * @property ActModel $model
 */
class DiaryActs extends \yii\db\ActiveRecord
{
    public $cnt;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'controll_acts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time', 'model_id'], 'required'],
            [['time', 'model_id'], 'integer'],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => DiaryActModel::className(), 'targetAttribute' => ['model_id' => 'id']],
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
            'model_id' => 'Model ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAtes()
    {
        return $this->hasMany(DiaryAte::className(), ['act_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActModel()
    {
        return $this->hasOne(DiaryActModel::className(), ['id' => 'model_id']);
    }

    
    
    public  function beforeSave($options = [])
    {

        if (parent::beforeSave(1)) {
            if ($this->isNewRecord) {
                $this->time = time();

                return true;
            } else

                return true;
        } else
            return false;
    }
}
