<?php

namespace app\models;

use Yii;
use yii\db\TableSchema;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $name
 * @property integer $frequency
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'frequency'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'frequency' => 'Frequency',
        ];
    }

    public static function addTags($tags_str, $id)
    {
        $tags = self::string2array($tags_str);

        foreach($tags as $one)
        {
            $tag_exists = Tag::find()
                //->where('name = ' . $tag)
                ->where("name = '".$one."'")
                ->one();
            //var_dump($tag_exists); exit;
            if($tag_exists == null)
            {
                $tag = new Tag;
                $tag->name = $one;
                $tag->frequency = 1;
                $tag->items .= $id;
                $tag->save();
            }
            else{
                $tag_exists->frequency++;
                $tag_exists->items .= ",".$id;
                $tag_exists->update();
            }
        }
    }

    public static function string2array($tags) {
        return preg_split('/\s*,\s*/', trim($tags), -1, PREG_SPLIT_NO_EMPTY);
    }

    public static function array2string($tags) {
        return implode(', ', $tags);
    }


    public function removeTags($tags)
    {
        if(empty($tags))
            return;

        $this->deleteAll('frequency<=0');
    }

    public function findTagWeights($limit)
    {
        $models=$this->findAll(array(
            'order'=>'frequency DESC',

        ));

        $total=0;

        foreach($models as $model)
            $total+=$model->frequency;

        $tags=array();

        if($total>0)
        {
            foreach($models as $model)
                $tags[$model->name]=8+(int)(16*$model->frequency/($total+10));
            ksort($tags);
        }
        return $tags;
    }
}
