<?php
namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

class SongtextSearch extends SongText
{
    public function rules()
    {
        return [

            [['title'], 'save'],
        ];
    }


    public function search($params)
    {
        $query = SongText::find()->where(['text' => '']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);


        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}