<?php
namespace app\controllers;

use app\components\BackEndController;
use app\components\TranslateHelper;
use app\models\Testing;
use app\models\ArticlesContent;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\Url;
use Yii;
use yii\data\ActiveDataProvider;

class TestingController extends BackEndController
{
    public $layout = 'admin';

    public function actionIndex()
    {
        $testings = Testing::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $testings,
        ]);

        return $this->render('index', ['testings' => $dataProvider]);
    }

    /**
     * Создание контента
     * @return string
     */
    public function actionCreate()
    {

        $model = new Testing();

        $uploadImg = new UploadForm();


        if (Yii::$app->request->isPost) {

            $uploadImg->img = UploadedFile::getInstance($uploadImg, 'img');

           if ($uploadImg->img && $uploadImg->validate()) {
                $uploadImg->img->saveAs('uploads/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' . $uploadImg->img->extension);

            } else {
                print_r($uploadImg->getErrors());
            }
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->question = Yii::$app->request->post('Testing')['question'];
            $model->answer = Yii::$app->request->post('Testing')['answer'];
            $model->right = Yii::$app->request->post('Testing')['right'];
            $model->article_id = Yii::$app->request->post('Testing')['article_id'];

            if (isset($uploadImg->img))
                $model->img = Url::base() . 'uploads/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' . $uploadImg->img->extension;
            $model->save(false);


            return $this->redirect(Url::toRoute('testing/index'));

        } else {

            return $this->render('_form', [
                'model' => $model,
                'uploadImg' => $uploadImg,

            ]);
        }

    }

    public function actionUpdate($id)
    {

        $model = $this->loadModel($id);

        $uploadImg = new UploadForm();

        if (Yii::$app->request->isPost) {

            $uploadImg->img = UploadedFile::getInstance($uploadImg, 'img');

            if ($uploadImg->img && $uploadImg->validate()) {
                $uploadImg->img->saveAs('uploads/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' . $uploadImg->img->extension);

            } else {
                print_r($uploadImg->getErrors());
            }
        }

        //var_dump($uploadImg); exit;
        if ($model->load(Yii::$app->request->post())) {
            $model->question = Yii::$app->request->post('Testing')['question'];
            $model->answer = Yii::$app->request->post('Testing')['answer'];
            $model->right = Yii::$app->request->post('Testing')['right'];
            $model->article_id = Yii::$app->request->post('Testing')['article_id'];

            if (isset($uploadImg->img))
                $model->img = Url::base() . 'uploads/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' . $uploadImg->img->extension;
            $model->save(false);

            return $this->redirect(Url::toRoute('testing/index'));
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
            $testing = Testing::find();
            $dataProvider = new ActiveDataProvider([
                'query' => $testing,
            ]);

            return $this->render('index', ['testing' => $dataProvider]);
        } else {
            throw new \yii\web\HttpException(404, 'Cant delete record.');
        };

    }

}