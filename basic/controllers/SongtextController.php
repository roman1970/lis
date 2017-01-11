<?php
namespace app\controllers;

use app\components\BackEndController;
use app\models\SongText;
//use app\models\SongTextSearch;
use app\models\SongtextSearch;
use app\models\Source;
use yii\helpers\Url;
use Yii;
use yii\data\ActiveDataProvider;

class SongtextController extends BackEndController
{
    public $layout = 'admin';

    public function actionIndex()
    {
        /*
        $authors = Author::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $authors,
        ]);

        return $this->render('index', ['authors' => $dataProvider]);
        */

        $searchModel = new SongtextSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', ['texts' => $dataProvider, 'searchModel' => $searchModel]);
    }

    /**
     * Создание автораа
     * @return string
     */
    public function actionCreate()
    {
        $model = new SongText();


        if ($model->load(Yii::$app->request->post())) {
            $model->title = Yii::$app->request->post('SongText')['title'];
            $model->text = Yii::$app->request->post('SongText')['text'];
            $model->link = Yii::$app->request->post('SongText')['link'];
            if(Source::find()->where(['title' => Yii::$app->request->post('SongText')['source_title']])->one()){

                $model->source_id = Source::find()->where(['title' => Yii::$app->request->post('SongText')['source_title']])->one()->id;
            }
            else $model->source_id = 2;

            $model->save(false);

            $texts = SongText::find();
            $dataProvider = new ActiveDataProvider([
                'query' => $texts,
            ]);

            return $this->redirect(Url::toRoute('songtext/index'));

        } else {

            return $this->render('_form', [
                'model' => $model,

            ]);
        }

    }

    public function actionUpdate($id){

        $model = $this->loadModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->title = Yii::$app->request->post('SongText')['title'];
            $model->text = Yii::$app->request->post('SongText')['text'];
            $model->link = Yii::$app->request->post('SongText')['link'];
            if(Source::find()->where(['title' => Yii::$app->request->post('SongText')['source_title']])->one()){

                $model->source_id = Source::find()->where(['title' => Yii::$app->request->post('SongText')['source_title']])->one()->id;
            }
            else $model->source_id = 2;

            $model->save(false);

            $texts = SongText::find();
            $dataProvider = new ActiveDataProvider([
                'query' => $texts,
            ]);

            return $this->redirect(Url::toRoute('songtext/index'));


        } else {

            return $this->render('_form', [
                'model' => $model,

            ]);
        }

    }

    public function actionDelete($id)
    {

        if ($model = $this->loadModel($id)->delete()) {
            $searchModel = new SongtextSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


            return $this->render('index', ['texts' => $dataProvider, 'searchModel' => $searchModel]);
        } else {
            throw new \yii\web\HttpException(404, 'Cant delete record.');
        }

    }

    public function loadModel($id)
    {

        $model = SongText::findOne($id);

        if ($model === null)
            throw new \yii\web\HttpException(404, 'The requested page does not exist.');
        return $model;
    }



}