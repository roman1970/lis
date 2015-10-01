<?php
namespace app\controllers;

use app\components\BackEndController;
use app\components\TranslateHelper;
use app\models\Articles;
use Yii;
use yii\data\ActiveDataProvider;

class ArticlesController extends BackEndController
{
    public $layout = 'admin';

    public function actionIndex()
    {
        $articles = Articles::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $articles,
        ]);

        return $this->render('index', ['articles' => $dataProvider]);
    }

    /**
     * Создание контента
     * @return string
     */
    public function actionCreate()
    {

        $model = new Articles();

        if ($model->load(Yii::$app->request->post())) {
            $model->text = Yii::$app->request->post('Articles')['text'];
            $model->title = Yii::$app->request->post('Articles')['title'];
            $model->alias = TranslateHelper::translit(Yii::$app->request->post('Articles')['title']);
            $model->site_id = Yii::$app->request->post('Articles')['site_id'];
            $model->cat_id = Yii::$app->request->post('Articles')['cat_id'];

            $model->save();

            $articles = Articles::find();
            $dataProvider = new ActiveDataProvider([
                'query' => $articles,
            ]);

            return $this->render('index', ['articles' => $dataProvider]);

        } else {

            return $this->render('_form', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Удаляет контент
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\web\HttpException
     */
    public function actionDelete($id)
    {

        if ($model = $this->loadModel($id)->delete()) {
            $articles = Articles::find();
            $dataProvider = new ActiveDataProvider([
                'query' => $articles,
            ]);

            return $this->render('index', ['articles' => $dataProvider]);
        } else {
            throw new \yii\web\HttpException(404, 'Cant delete record.');
        };


    }

    /**
     * Загружает запись модели текущего контроллера по айдишнику
     * @param $id
     * @return null|static
     * @throws \yii\web\HttpException
     */
    public function loadModel($id)
    {

        $model = Articles::findOne($id);

        if ($model === null)
            throw new \yii\web\HttpException(404, 'The requested page does not exist.');
        return $model;
    }

}

