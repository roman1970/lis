<?php
namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

class ItemsQueSearch extends Items
{
    public function rules()
    {
        return [

            [['text', 'tags', 'title'], 'save'],
        ];
    }


    public function search($params){
        $query = Items::find()->where(['play_status' => 1]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);


        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'tags', $this->tags])
            //  ->orFilterWhere(['like', 'fio', $this->search])
            //  ->orFilterWhere(['like', 'address', $this->search])
            //  ->orFilterWhere(['like', 'comment', $this->search])
        ;

        return $dataProvider;
    }

    public function searchRepertoire($params){
        $query = Items::find()->where('(cat_id = 90 or cat_id = 89) and play_status=1');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);


        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'tags', $this->tags])
            //  ->orFilterWhere(['like', 'fio', $this->search])
            //  ->orFilterWhere(['like', 'address', $this->search])
            //  ->orFilterWhere(['like', 'comment', $this->search])
        ;

        return $dataProvider;
    }

}