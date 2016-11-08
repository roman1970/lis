<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "telbase".
 *
 * @property integer $id
 * @property string $date_nach
 * @property string $time_nach
 * @property string $nom_tel
 * @property string $zak_gr
 * @property string $zv
 * @property string $source
 * @property string $a
 * @property string $dlitelnost
 * @property string $c
 * @property string $dut
 * @property double $f
 * @property string $date_okon
 * @property string $time_okon
 * @property string $cur
 * @property string $gmt
 */
class Telbase extends \yii\db\ActiveRecord
{
   
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'telbase';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['f'], 'number'],
            [['date_nach', 'time_nach', 'nom_tel', 'zak_gr', 'zv', 'source', 'a', 'dlitelnost', 'c', 'dut', 'date_okon', 'time_okon', 'cur', 'gmt'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_nach' => 'Date Nach',
            'time_nach' => 'Time Nach',
            'nom_tel' => 'Nom Tel',
            'zak_gr' => 'Zak Gr',
            'zv' => 'Zv',
            'source' => 'Source',
            'a' => 'A',
            'dlitelnost' => 'Dlitelnost',
            'c' => 'C',
            'dut' => 'Dut',
            'f' => 'F',
            'date_okon' => 'Date Okon',
            'time_okon' => 'Time Okon',
            'cur' => 'Cur',
            'gmt' => 'Gmt',
        ];
    }
}
