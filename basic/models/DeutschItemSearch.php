<?php
namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

class DeutschItemSearch extends DeutschItem
{
    public function rules()
    {
        return [

            [['d_word', 'e_word'], 'save'],
        ];
    }


    public function search($params)
    {
        $query = DeutschItem::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);


        $query->andFilterWhere(['like', 'd_word', $this->d_word]);

        return $dataProvider;
    }
}