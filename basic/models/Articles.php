<?php
namespace app\models;

use Yii;
use yii\base\Model;

class Articles extends \yii\db\ActiveRecord
{
    public $count_contents;
	public $image;
    public $image2;
	public static $arrStatus = ['published'=>'Опубликовано','new'=>'Новый(не опубликован)'];
	public static $pathImg = 'uploads/content/';
	public $cntPhoto;
	
	const STATUS_NEW = 'new';
	const STATUS_PUBLISHED = 'published';
	const STATUS_DELETED = 'deleted';
	
	const IS_TESTING_NO = 0;
	const IS_TESTING_YES = 1;

	/**
	 * @return string the associated database table name
	 */
    public static function tableName()
	{
		return 'qparticles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			['title, site_id', 'required'],
			['site_id, cat_id', 'numerical', 'integerOnly'=>true],
			['title, alias, img, tags', 'length', 'max'=>255],
			['alias', 'match', 'pattern'=>'/^[A-Za-z0-9\-.]+$/'],
			['img, anons, anons_img, status, anons_show, rating', 'safe'],
			['image, image2', 'file', 'types'=>['jpg', 'jpeg', 'png', 'gif'], 'allowEmpty'=>true],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			['id, title, alias, d_created, img, anons, anons_img, site_id, cat_id, status_quality, scheme_id, add_scheme', 'safe', 'on'=>'search'],
		];
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'title' => 'Заголовок',
			'alias' => 'Алиас',
			'd_created' => 'Дата создания',
			'img' => 'Фотография',
			'anons' => 'Анонс',
			'site_id' => 'Сайт',
			'cat_id' => 'Категория',
			'image' => 'Превью',
			'anons_img' => 'Картинка анонса',
			'image2' => 'Картинка анонса',
			'status' => 'Статус',
			'anons_show' => 'Показывать анонс',
			'tags' => 'Теги',
            'status_quality' => 'status_quality',
            'scheme_id' => 'Схема',
            'add_scheme' => 'Использовать в схеме',
			'count_rotator' => 'Кол-во переходов по ротатору',
		];
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

		/*$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('d_created',$this->d_created,true);
		$criteria->compare('img',$this->img,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('anons',$this->anons,true);
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('cat_id',$this->cat_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
		*/
	}

    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'cat_id']);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Articles the static model class
	 */
	/*public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	*/
	/*
	Ф-ция генерит алиас
	*/
    /*
	public function generateAlias()
	{
		// Алиас перегенеривается в afterSave() | Так сделано чтобы нигде ничего не нарушить
		if (!empty($this->title))
		{
			if (!empty($this->alias) && preg_match('/^[A-Za-z0-9\-]+$/', $this->alias))
				return true;
			
			$this->alias = $alias = CTranslateHelper::translit($this->title);
			$i = 0;
			
			while ((bool)self::model()->count(array('condition'=>'t.alias = :alias', 'params'=>array(':alias'=>$this->alias))))
			{
				$this->alias = $alias . '-' . $i++;
			}

			return true;
		}
		else
			return false;
	}
	*/
	/*
	Ф-ция расставляет сортировку для виджета который выводит статьи под статьей
	Принцип: несколько новых, одна топовая, несколько новых, одна то.. и т.д. вобщем.
	*/
    /*
	public static function setSort($siteId)
	{
		$criteria = new CDbCriteria();
		$criteria->compare('t.site_id', $siteId);
		$criteria->compare('t.status', self::STATUS_PUBLISHED);
		$count = self::model()->count($criteria);
		
		unset($criteria);
		
		if ($count > 0)
		{
			$ratio = Yii::app()->db->createCommand()
				->select('text')
				->from('site_settings')
				->where('site_id = :site_id AND type = :ratio')
				->queryScalar(array(
					':site_id' => $siteId,
					':ratio' => 'ratio_article',
				));
			$ratio = trim($ratio);

			if (!empty($ratio) && preg_match('/^(\d+)\/(\d+)$/', $ratio, $match))
			{
				$left = (int)$match[1];
				$right = (int)$match[2];

				unset($match, $ratio);

				$leftLimit = ceil(($left * $count) / ($left + $right));
				$rightLimit = $count - $leftLimit;

				$rightArticles = Yii::app()->db->createCommand()
					->select('t.*')
					->from('{{articles}} t')
					->where('t.site_id = :site_id AND t.status = :status_published')
					->order('t.rating DESC, t.d_created DESC, t.id DESC')
					->limit($rightLimit)
					->queryAll(true, array(
						':site_id' => $siteId,
						':status_published' => self::STATUS_PUBLISHED,
					));

				$leftArticles = Yii::app()->db->createCommand()
					->select('t.*')
					->from('(SELECT t.* FROM {{articles}} t WHERE t.site_id = :site_id AND t.status = :status_published ORDER BY t.rating ASC, t.d_created ASC, t.id ASC LIMIT '.$leftLimit.') t')
					->order('t.d_created DESC, t.id DESC')
					->queryAll(true, array(
						':site_id' => $siteId,
						':status_published' => self::STATUS_PUBLISHED,
					));

				$sort = array();
				$rows = ceil($count / ($left + $right));

				// Перебираем по строке
				for ($i = 0; $i < $rows; $i++)
				{
					for ($j = 0; $j < $left; $j++)
					{
						if (!empty($leftArticles))
						{
							$model = array_shift($leftArticles);
							$sort[] = $model['id'];
						}
					}

					for ($j = 0; $j < $right; $j++)
					{
						if (!empty($rightArticles))
						{
							$model = array_shift($rightArticles);
							$sort[] = $model['id'];
						}
					}
				}
				
				unset($j, $model, $leftArticles, $rightArticles);
				
				if (!empty($sort))
				{
					foreach ($sort as $i => $id)
					{
						Yii::app()->db->createCommand()->update('{{articles}}', array(
							'sort' => $i + 1,
						), 'id = :id', array(':id'=>$id));
					}
					
					return true;
				}
					
//				print_r($sort);
//				echo "\r\ncount: {$count} | left: {$left} | right: {$right} | rows: {$rows} | leftLimit: {$leftLimit} | rightLimit: {$rightLimit}\r\n";
				
				return false;
			}
			
			return false;
		}
		
		return false;
	}
	
	private $_justCreated = false;
	
	public function beforeSave()
	{
		if ($this->isNewRecord)
		{
			$this->d_created = date('Y-m-d H:i:s');
			$this->_justCreated = true;
			
			if (empty($this->alias))
				$this->alias = CTranslateHelper::translit($this->title);
		}
		
		return parent::beforeSave();
	}
	
	public function afterSave()
	{
		if ($this->_justCreated)
		{
			Yii::app()->db->createCommand()->update('{{articles}}', array(
				'alias' => $this->id,
			), 'id = :id', array(
				':id' => $this->id,
			));
		}
		
		//Не пересчитываем сортировку каждый раз при сохранении
		if(!isset($this->id))
            self::setSort($this->site_id);
		return parent::afterSave();
	}

    public static function getLinkRotator($hash)
    {
        $domen = 'http://go.m2corp.ru/';
        if(!empty($hash))
            return $domen.'?hash='.$hash;
        else
            return false;
    }
	*/

    /**
     * Перемешанный массив определенного количества элементов
     * @param integer $changeSiteParam
     * @param integer $start
     * @return array
     */
    /*
    public static function arrOfShuffledSites($countOfElements, $start)
	{
		$arrRand = array();
			$arr = range($start, $countOfElements-1);
			shuffle($arr);
				foreach ($arr as $number) {
				$arrRand[] = $number;
				}
		return $arrRand;
    }
	*/
	/**
	 * Делает +1 к кол-ву переходов по ротатору
	 * @return boolean
	 */
    /*
	public function countRotatorUp()
	{
		$this->count_rotator++;
		return $this->save(false, array('count_rotator'));
	}
	*/
	/**
	 * Проверяет рекламируется статья или нет
	 * @return boolean
	 */
    /*
	public function isTesting()
	{
		return (bool)$this->is_testing;
	}
	
	/**
	 * Отправляет статью рекламироваться
	 * @return boolen
	 */
	public function sendToTest()
	{
		$this->is_testing = self::IS_TESTING_YES;
		return $this->save(false, array('is_testing'));
	}
	
	/**
	 * Снимает с рекламирования статьи
	 * @return boolean
	 */
	public function returnFromTest()
	{
		$this->is_testing = self::IS_TESTING_NO;
		return $this->save(false, array('is_testing'));
	}
}