<?php
namespace app\controllers;

use app\components\BackEndController;
use app\models\Categories;
use app\models\TestQuestions;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

class QuestController extends BackEndController
{
    public $layout = 'admin';


    public function actionIndex()
    {
        $questions = TestQuestions::find()->orderBy('id DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $questions,
        ]);

        return $this->render('index', ['questions' => $dataProvider]);
    }

    public function actionCreate(){
        $model = new TestQuestions();

        if ($model->load(Yii::$app->request->post())) {
            $model->body = Yii::$app->request->post('TestQuestions')['body'];

            if(Categories::find()->where(['title' => Yii::$app->request->post('TestQuestions')['cat_title']])->one()){

                $model->cat_id = Categories::find()->where(['title' => Yii::$app->request->post('TestQuestions')['cat_title']])->one()->id;
            }
            else $model->cat_id = 57;

            $model->save(false);

            return $this->redirect(Url::toRoute('quest/index'));

        } else {

            return $this->render('form', [
                'model' => $model,

            ]);
        }
    }
    
    public function actionOne($id){
        $quest = TestQuestions::findOne($id);
        
        return $this->render('quest', ['model' => $quest]);
        
    }
    public function actionUpdate(){
        
    }
    

}