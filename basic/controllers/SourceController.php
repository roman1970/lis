<?php
namespace app\controllers;

use app\components\BackEndController;
use app\components\TranslateHelper;
use app\models\Source;
use app\models\ArticlesContent;
use app\models\SourceSearch;
use app\models\UploadForm;
use yii\helpers\Url;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

class SourceController extends BackEndController
{
    public $layout = 'admin';

    public function actionIndex()
    {
       /* $sources = Source::find()->orderBy('id DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $sources,
        ]);

        return $this->render('index', ['sources' => $dataProvider]);
       */

        $searchModel = new SourceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', ['sources' => $dataProvider, 'searchModel' => $searchModel]);
    }

    /**
     * Создание источника
     * @return string
     */
    public function actionCreate()
    {
        $model = new Source();
        
        $uploadImg = new UploadForm();

        if (Yii::$app->request->isPost) {
            
            $uploadImg->img = UploadedFile::getInstance($uploadImg, 'img');

            if($uploadImg->img && $uploadImg->validate()) {
                $uploadImg->img->saveAs('uploads/covers/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension);

            }
            else { print_r($uploadImg->getErrors()); }
        }


        if ($model->load(Yii::$app->request->post())) {
            $model->title = Yii::$app->request->post('Source')['title'];
            $model->author_id = Yii::$app->request->post('Source')['author_id'];
            $model->status = Yii::$app->request->post('Source')['status'];
            $model->cat_id = Yii::$app->request->post('Source')['cat_id'];
            if(isset($uploadImg->img))
                $model->cover = Url::base().'uploads/covers/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension;
            $model->save(false);

            $sources = Source::find();
            $dataProvider = new ActiveDataProvider([
                'query' => $sources,
            ]);

            return $this->redirect(Url::toRoute('source/index'));

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
                $uploadImg->img->saveAs('uploads/covers/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension);

            }
            else { print_r($uploadImg->getErrors()); }
        }


        if ($model->load(Yii::$app->request->post())) {
            $model->title = Yii::$app->request->post('Source')['title'];
            $model->author_id = Yii::$app->request->post('Source')['author_id'];
            $model->status = Yii::$app->request->post('Source')['status'];
            $model->cat_id = Yii::$app->request->post('Source')['cat_id'];
            if(isset($uploadImg->img))
                $model->cover = Url::base().'uploads/covers/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension;
            $model->save(false);

            return $this->redirect(Url::toRoute('source/index'));
        } else {

            return $this->render('_form', [
                'model' => $model,
                'uploadImg' => $uploadImg,
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