<?php

namespace app\models;

use Yii;


class SoccercodeTest extends \yii\db\ActiveRecord
{

    public static function getDb()
    {
        return Yii::$app->get('db_test');
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'foo_matches';
    }

   
}
