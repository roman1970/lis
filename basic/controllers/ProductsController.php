<?php
namespace app\controllers;

use app\components\BackEndController;
use app\components\TranslateHelper;
use app\models\Articles;
use app\models\ArticlesContent;
use app\models\Products;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\Url;
use Yii;
use yii\data\ActiveDataProvider;

class ProductsController extends BackEndController
{
    public function actionIndex()
    {
        $products = Products::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $products,
        ]);

        return $this->render('index', ['products' => $dataProvider]);
    }

    /**
     * Создание контента
     * @return string
     */
    public function actionCreate()
    {

        $model = new Products();

        $uploadImg = new UploadForm();

        if (Yii::$app->request->isPost) {

            $uploadImg->img = UploadedFile::getInstance($uploadImg, 'img');

           if($uploadImg->img && $uploadImg->validate()) {
                $uploadImg->img->saveAs('uploads/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension);

            }
            else { print_r($uploadImg->getErrors()); }
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->name = Yii::$app->request->post('Products')['name'];
            $model->cat_id = Yii::$app->request->post('Products')['cat_id'];
            $model->price = Yii::$app->request->post('Products')['price'];
            $model->description = Yii::$app->request->post('Products')['description'];

            if(isset($uploadImg->img))
                $model->photo = Url::base().'uploads/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension;
            $model->save(false);

            return $this->redirect(Url::toRoute('products/index'));

        } else {

            return $this->render('_form', [
                'model' => $model,
                'uploadImg' => $uploadImg,

            ]);
        }

    }

    public function actionUpdate($id){

        $model = $this->loadModel($id);

        $uploadImg = new UploadForm();

        if (Yii::$app->request->isPost) {

            $uploadImg->img = UploadedFile::getInstance($uploadImg, 'img');

            if($uploadImg->img && $uploadImg->validate()) {
                $uploadImg->img->saveAs('uploads/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension);

            }
            else { print_r($uploadImg->getErrors()); }
        }

        //var_dump($uploadImg); exit;
        if ($model->load(Yii::$app->request->post())) {
            $model->name = Yii::$app->request->post('Products')['name'];
            $model->cat_id = Yii::$app->request->post('Products')['cat_id'];
            $model->price = Yii::$app->request->post('Products')['price'];
            $model->description = Yii::$app->request->post('Products')['description'];

            if(isset($uploadImg->img))
                $model->photo = Url::base().'uploads/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension;
            $model->save(false);

            return $this->redirect(Url::toRoute('products/index'));
        } else {

            return $this->render('_form', [
                'model' => $model,
                'uploadImg' => $uploadImg,
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
            $products = Products::find();
            $dataProvider = new ActiveDataProvider([
                'query' => $products,
            ]);

            return $this->render('index', ['products' => $dataProvider]);
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

        $model = Products::findOne($id);

        if ($model === null)
            throw new \yii\web\HttpException(404, 'The requested page does not exist.');
        return $model;
    }


}