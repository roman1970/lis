<?php
namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

class ItemsSearch extends Items 
{
    public function rules()
    {
        return [

            [['text', 'tags', 'title'], 'save'],
          ];
    }


    public function search($params){
        $query = Items::find()->orderBy('id DESC');
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