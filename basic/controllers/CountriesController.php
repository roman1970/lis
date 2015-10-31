<?php
namespace app\controllers;

use app\components\BackEndController;
use app\models\Country;
use Yii;
use yii\data\ActiveDataProvider;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\Url;


class CountriesController extends BackEndController
{
    public $layout = 'admin';


    public function actionIndex()
    {
        $countries = Country::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $countries,
            'pagination' => [
                'pageSize' => 20,
                'pageParam' => 'page',
                'validatePage' => false,
            ],
        ]);

        return $this->render('index', ['countries' => $dataProvider]);

    }

    /**
     * Создание контента
     * @return string
     */
    public function actionCreate()
    {

        $model = new Country();

        $uploadImg = new UploadForm();


        if (Yii::$app->request->isPost) {

            $uploadImg->img = UploadedFile::getInstance($uploadImg, 'img');

           if($uploadImg->img && $uploadImg->validate()) {
                $uploadImg->img->saveAs('uploads/icoflags/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension);

            }
            else { print_r($uploadImg->getErrors()); }
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->name = Yii::$app->request->post('Country')['name'];
            $model->iso_code = Yii::$app->request->post('Country')['iso_code'];
            $model->soc_abrev = Yii::$app->request->post('Country')['soc_abrev'];
            $model->soccer_code = Yii::$app->request->post('Country')['soccer_code'];

            if(isset($uploadImg->img))
                $model->icon = Url::base().'uploads/icoflags/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension;
            $model->save(false);


            return $this->redirect(Url::toRoute('countries/index'));

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
                $uploadImg->img->saveAs('uploads/icoflags/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension);

            }
            else { print_r($uploadImg->getErrors()); }
        }

        //var_dump($uploadImg); exit;
        if ($model->load(Yii::$app->request->post())) {
            $model->name = Yii::$app->request->post('Country')['name'];
            $model->iso_code = Yii::$app->request->post('Country')['iso_code'];
            $model->soc_abrev = Yii::$app->request->post('Country')['soc_abrev'];
            $model->soccer_code = Yii::$app->request->post('Country')['soccer_code'];

            if(isset($uploadImg->img))
                $model->icon = Url::base().'uploads/icoflags/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension;
            $model->save(false);

            return $this->redirect(Url::toRoute('countries/index'));
        } else {

            return $this->render('_form', [
                'model' => $model,

                'uploadImg' => $uploadImg,
            ]);
        }

    }

    /**
     * Загружает запись модели текущего контроллера по айдишнику
     * @param $id
     * @return null|static
     * @throws \yii\web\HttpException
     */
    public function loadModel($id)
    {

        $model = Country::findOne($id);

        if ($model === null)
            throw new \yii\web\HttpException(404, 'The requested page does not exist.');
        return $model;
    }


}