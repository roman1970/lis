<?php

namespace app\models;

use creocoder\nestedsets\NestedSetsBehavior;
use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $tree
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 * @property string $name
 */
class Category extends \yii\db\ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->get('db_postgres');
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          //  [['tree', 'lft', 'rgt', 'depth', 'name'], 'required'],
           // [['tree', 'lft', 'rgt', 'depth'], 'default', 'value' => null],
           // [['tree', 'lft', 'rgt', 'depth'], 'integer'],
          //  [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tree' => 'Tree',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
            'name' => 'Name',
        ];
    }

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                //'treeAttribute' => 'tree',
               // 'leftAttribute' => 'lft',
               // 'rightAttribute' => 'rgt',
               // 'depthAttribute' => 'level',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new CategoriesQuery(get_called_class());
    }
}
