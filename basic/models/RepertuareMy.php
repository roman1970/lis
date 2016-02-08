<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "o_reper_sv".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property integer $cat
 * @property string $play
 * @property integer $f
 * @property string $author
 * @property string $group
 * @property string $date
 * @property string $minus
 * @property string $gpro
 * @property string $accord
 * @property integer $vyb
 * @property string $preamb
 */
class RepertuareMy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o_reper_sv';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'text', 'cat', 'play', 'f', 'author', 'group', 'date', 'minus', 'gpro', 'accord', 'vyb', 'preamb'], 'required'],
            [['text', 'preamb'], 'string'],
            [['cat', 'f', 'vyb'], 'integer'],
            [['name', 'play', 'author', 'group', 'date', 'minus', 'gpro', 'accord'], 'string', 'max' => 255],
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
            'text' => 'Text',
            'cat' => 'Cat',
            'play' => 'Play',
            'f' => 'F',
            'author' => 'Author',
            'group' => 'Group',
            'date' => 'Date',
            'minus' => 'Minus',
            'gpro' => 'Gpro',
            'accord' => 'Accord',
            'vyb' => 'Vyb',
            'preamb' => 'Preamb',
        ];
    }
}
