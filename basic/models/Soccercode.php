<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "soccerstand_match".
 *
 * @property integer $id
 * @property string $zee
 * @property integer $zb
 * @property string $zy
 * @property string $zс
 * @property string $zd
 * @property integer $ze
 * @property integer $zf
 * @property string $zh
 * @property integer $zj
 * @property string $zl
 * @property string $zx
 * @property integer $zcc
 * @property string $aa
 * @property integer $ad
 * @property string $cx
 * @property integer $ax
 * @property integer $av
 * @property integer $bx
 * @property string $wn
 * @property string $af
 * @property string $wv
 * @property integer $as
 * @property integer $az
 * @property integer $ah
 * @property integer $bb
 * @property integer $bd
 * @property string $wm
 * @property string $ae
 * @property integer $ag
 * @property integer $ba
 * @property integer $bc
 * @property string $an
 * @property string $za
 */
class Soccercode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'soccerstand_match';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['zee', 'zy', 'zс', 'zd', 'zh', 'zl', 'zx', 'aa', 'cx', 'wn', 'af', 'wv', 'wm', 'ae', 'an', 'za'], 'required'],
            [['zb', 'ze', 'zf', 'zj', 'zcc', 'ad', 'ax', 'av', 'bx', 'as', 'az', 'ah', 'bb', 'bd', 'ag', 'ba', 'bc'], 'integer'],
            [['zee', 'zy', 'zс', 'zd', 'zh', 'zl', 'zx', 'aa', 'cx', 'wn', 'af', 'wv', 'wm', 'ae', 'an', 'za'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'zee' => 'Zee',
            'zb' => 'Zb',
            'zy' => 'Zy',
            'zс' => 'Zс',
            'zd' => 'Zd',
            'ze' => 'Ze',
            'zf' => 'Zf',
            'zh' => 'Zh',
            'zj' => 'Zj',
            'zl' => 'Zl',
            'zx' => 'Zx',
            'zcc' => 'Zcc',
            'aa' => 'Aa',
            'ad' => 'Ad',
            'cx' => 'Cx',
            'ax' => 'Ax',
            'av' => 'Av',
            'bx' => 'Bx',
            'wn' => 'Wn',
            'af' => 'Af',
            'wv' => 'Wv',
            'as' => 'As',
            'az' => 'Az',
            'ah' => 'Ah',
            'bb' => 'Bb',
            'bd' => 'Bd',
            'wm' => 'Wm',
            'ae' => 'Ae',
            'ag' => 'Ag',
            'ba' => 'Ba',
            'bc' => 'Bc',
            'an' => 'An',
            'za' => 'Za',
        ];
    }
}
