<?php
namespace app\models;

use Yii;
use yii\base\Model;
use creocoder\nestedsets\NestedSetsBehavior;
use app\components\CategoriesQuery;
/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $id_parent
 */
class Categories extends \yii\db\ActiveRecord
{
    public $rootCat;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qpcategory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['name'], 'required'],
            [['title'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'rootCat' => 'Корневая категория'
            // 'id_parent' => 'Id Parent',
        ];
    }

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
                'leftAttribute' => 'lft',
                'rightAttribute' => 'rgt',
                'depthAttribute' => 'level',
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