<?php

namespace app\models;

use Yii;
use yii\base\Model;
/**
 * This is the model class for table "qparticles_content".
 *
 * The followings are the available columns in table 'qparticles_content':
 * @property integer $id
 * @property integer $articles_id
 * @property string $body
 * @property string $minititle
 * @property string $img
 * @property integer $page
 *
 * The followings are the available model relations:
 * @property Articles $articles
 * @property ArticlesFieldsContent[] $articlesFieldsContents
 */
class ArticlesContent extends \yii\db\ActiveRecord
{
    public static $templateFormJs = '=i=';
    public $image;
    public $origMinititle;
    public $source_title;

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'qparticles_content';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.

        return [
            [['articles_id','minititle', 'body', 'source_id'], 'required'],
            [['body'], 'string'],
            [['articles_id', 'source_id'], 'integer'],
            [['minititle'], 'string', 'max' => 255],
            [['articles_id'], 'exist', 'skipOnError' => true, 'targetClass' => Articles::className(), 'targetAttribute' => ['articles_id' => 'id']],
            [['source_id'], 'exist', 'skipOnError' => true, 'targetClass' => Source::className(), 'targetAttribute' => ['source_id' => 'id']],
        ];

    }
    /*
    /**
     * @return array relational rules.
     */
    /*
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'articles' => [self::BELONGS_TO, 'Articles', 'articles_id'],
            //'articlesFieldsContents' => [self::HAS_MANY, 'ArticlesFieldsContent', 'article_content_id'],
        ];
    }
    */

    public function getArticles()
    {
        return $this->hasOne(Articles::className(), ['id' => 'articles_id']);
    }

    public function getSource()
    {
        return $this->hasOne(Source::className(), ['id' => 'source_id']);
    }
    /*
    public function getCategory()
    {
        return $this
            ->hasOne(Categories::className(), ['id' => 'articles_id'])
            ->viaTable(Articles::tableName(), ['cat_id' => 'id']);
    }
    */
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'articles_id' => 'Articles',
            'body' => 'Текст',
            'minititle' => 'короткий заголовок',
            'img' => 'фото',
            'image' => 'фотография',
            'page' => 'Номер страницы',

        ];
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->origMinititle = $this->minititle;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('articles_id', $this->articles_id);
        $criteria->compare('body', $this->body, true);
        $criteria->compare('minititle', $this->minititle, true);
        $criteria->compare('img', $this->img, true);
        $criteria->compare('page', $this->page);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ArticlesContent the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}