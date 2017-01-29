<?php
namespace app\controllers;

use app\components\BackEndController;
use app\models\TestAnswers;
use app\models\TestQuestions;
use yii\base\Model;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class AnswerController extends BackEndController
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

        $model = new TestAnswers();

        if ($model->load(Yii::$app->request->post())) {
            $model->text = Yii::$app->request->post('TestAnswers')['body'];


            $model->save(false);

            return $this->redirect(Url::toRoute('answer/index'));

        } else {

            return $this->render('form_add_answer', [
                'model' => $model,

            ]);
        }
    }

    public function actionAdd($questId){
        
        $question = $this->findQuestion($questId);
        $model = new TestAnswers();
        $this->addOne($model, $questId);
        $question->link('answers', $model);
        return $this->render('form_add_answer', ['model' => $question]);
    }
    
    public function actionUpdate($questId){
        $question = $this->findQuestion($questId);
        //return var_dump($question->answers);
        $this->batchUpdate($question->answers);
        return $this->redirect(Url::toRoute('quest/index'));
    }


    protected function batchUpdate($items)
    {
        if (Model::loadMultiple($items, Yii::$app->request->post()) &&
            Model::validateMultiple($items)) {
            foreach ($items as $key => $item) {
                $item->save();
            }
        }
    }

    protected function findModel($id)
    {
        if (($model = TestAnswers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    protected function findQuestion($id)
    {
        if (($model = TestQuestions::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function addOne($model, $questId)
    {
        $model->body = '';
        $model->question_id = $questId;
    }


}