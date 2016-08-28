<?php
namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

class SourceSearch extends Source
{
    public function rules()
    {
        return [

            [['title'], 'save'],
        ];
    }


    public function search($params)
    {
        $query = Source::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);


        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
