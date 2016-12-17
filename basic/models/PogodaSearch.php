<?php
namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

class PogodaSearch extends PogodaXXI
{
    public function rules()
    {
        return [

            [['title'], 'save'],
        ];
    }


    public function search($params)
    {
        $query = PogodaXXI::find()->where(['max_temp' => '']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);


        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}