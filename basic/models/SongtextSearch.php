<?php
namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

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

    public function searchForArtist($params, $id)
    {

        $source_texts = implode(',', ArrayHelper::map(Source::find()->where("author_id = $id")->all(), 'id', 'id'));
        $query = SongText::find()->where(['text' => ''])->andWhere("source_id  IN (" . $source_texts . ")");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);


        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }

}