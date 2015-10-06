<?php
namespace app\controllers;

use app\components\BackEndController;
use app\models\Categories;
use Yii;

class CategoriesController extends BackEndController
{
    public $layout = 'admin';

    public function actionIndex()
    {
        $cats = Categories::find()->all();
       // $cats = Categories::find()->all();
        return $this->render('index', ['cats' => $cats]);
    }

    /**
     * Создание корневой категории
     * @return string
     * @TODO добавление title
     */
    public function actionCreate()
    {

        $model = new Categories();

        if($model->load(Yii::$app->request->post())){
            if (Yii::$app->request->post('Categories')['rootCat'] === '') {
                $model = new Categories(['name' => Yii::$app->request->post('Categories')['name']],
                    ['title' => Yii::$app->request->post('Categories')['title']],
                    ['cssclass' => Yii::$app->request->post('Categories')['cssclass']],
                    ['action' => Yii::$app->request->post('Categories')['action']]
                );
                $model->makeRoot();
                $cats = Categories::find()->roots()->all();
                // $cats = Categories::find()->all();
                return $this->render('index', ['cats' => $cats]);

            }

            else {
                $model = new Categories(['name' => Yii::$app->request->post('Categories')['name']],
                    ['title' => Yii::$app->request->post('Categories')['title']],
                    ['cssclass' => Yii::$app->request->post('Categories')['cssclass']],
                    ['action' => Yii::$app->request->post('Categories')['action']]

                );
                $rootCategory = Categories::find()
                    ->where(['id' => Yii::$app->request->post('Categories')['rootCat']])
                    ->one();

                $model->prependTo($rootCategory);

                $cats = Categories::find()->roots()->all();
                // $cats = Categories::find()->all();
                return $this->render('index', ['cats' => $cats]);
            }
        }
        else {
            return $this->render('_form', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Удаляет категорию
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\web\HttpException
     */
    public function actionDelete($id)
    {

        if($model=$this->loadModel($id)->delete()){
            $cats = Categories::find()->all();

            return $this->render(['index', ['cats' => $cats]]);
        } else {
            throw new \yii\web\HttpException(404,'Cant delete record.');
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

        $model=Categories::findOne($id);

        if($model===null)
            throw new \yii\web\HttpException(404,'The requested page does not exist.');
        return $model;
    }

}