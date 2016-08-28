<?php
namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

class AuthorSearch extends Author
{
    public function rules()
    {
        return [

            [['name'], 'save'],
        ];
    }


    public function search($params)
    {
        $query = Author::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);


        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}