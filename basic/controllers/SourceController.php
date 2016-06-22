<?php
namespace app\controllers;

use app\components\BackEndController;
use app\components\TranslateHelper;
use app\models\Source;
use app\models\ArticlesContent;
use yii\helpers\Url;
use Yii;
use yii\data\ActiveDataProvider;

class SourceController extends BackEndController
{
    public $layout = 'admin';

    public function actionIndex()
    {
        $sources = Source::find()->orderBy('id DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $sources,
        ]);

        return $this->render('index', ['sources' => $dataProvider]);
    }

    /**
     * Создание источника
     * @return string
     */
    public function actionCreate()
    {
        $model = new Source();


        if ($model->load(Yii::$app->request->post())) {
            $model->title = Yii::$app->request->post('Source')['title'];
            $model->author_id = Yii::$app->request->post('Source')['author_id'];
          $model->save(false);

            $sources = Source::find();
            $dataProvider = new ActiveDataProvider([
                'query' => $sources,
            ]);

            return $this->render('index', ['sources' => $dataProvider]);

        } else {

            return $this->render('_form', [
                'model' => $model,

            ]);
        }

    }

    public function actionUpdate($id){

        $model = $this->loadModel($id);


        //var_dump($uploadImg); exit;
        if ($model->load(Yii::$app->request->post())) {
            $model->title = Yii::$app->request->post('Source')['title'];
            $model->author_id = Yii::$app->request->post('Source')['author_id'];
            $model->save(false);

            return $this->redirect(Url::toRoute('source/index'));
        } else {

            return $this->render('_form', [
                'model' => $model,
            ]);
        }

    }

    public function actionDelete($id)
    {

        if ($model = $this->loadModel($id)->delete()) {
            $source = Source::find();
            $dataProvider = new ActiveDataProvider([
                'query' => $source,
            ]);

            return $this->render('index', ['sources' => $dataProvider]);
        } else {
            throw new \yii\web\HttpException(404, 'Cant delete record.');
        };

    }

    public function loadModel($id)
    {

        $model = Source::findOne($id);

        if ($model === null)
            throw new \yii\web\HttpException(404, 'The requested page does not exist.');
        return $model;
    }



}