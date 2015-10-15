<?php
namespace app\controllers;

use app\components\BackEndController;
use app\components\TranslateHelper;
use app\models\Articles;
use app\models\ArticlesContent;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\Url;
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

        $uploadFile = new UploadForm();
        $uploadImg = new UploadForm();


        if (Yii::$app->request->isPost) {
            $uploadFile->file = UploadedFile::getInstance($uploadFile, 'file');
            $uploadImg->img = UploadedFile::getInstance($uploadImg, 'img');

            if ($uploadFile->file && $uploadFile->validate()) {
                $uploadFile->file->saveAs('uploads/' . Yii::$app->translater->translit($uploadFile->file->baseName) . '.' .$uploadFile->file->extension);

            }
            elseif($uploadImg->img && $uploadImg->validate()) {
                $uploadImg->img->saveAs('uploads/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension);

            }
            else { print_r($uploadFile->getErrors()); }
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->text = Yii::$app->request->post('Articles')['text'];
            $model->title = Yii::$app->request->post('Articles')['title'];
            $model->alias = TranslateHelper::translit(Yii::$app->request->post('Articles')['title']);
            $model->site_id = Yii::$app->request->post('Articles')['site_id'];
            $model->cat_id = Yii::$app->request->post('Articles')['cat_id'];
            if(isset($uploadFile->file))
                $model->audio = Url::base().'uploads/' . Yii::$app->translater->translit($uploadFile->file->baseName) . '.' .$uploadFile->file->extension;

            if(isset($uploadImg->img))
                $model->img = Url::base().'uploads/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension;
            $model->save(false);

            $articles = Articles::find();
            $dataProvider = new ActiveDataProvider([
                'query' => $articles,
            ]);

            return $this->render('index', ['articles' => $dataProvider]);

        } else {

            return $this->render('_form', [
                'model' => $model,
                'uploadFile' => $uploadFile,
                'uploadImg' => $uploadImg,

            ]);
        }

    }

    public function actionUpdate($id){

        $model = $this->loadModel($id);
        $uploadFile = new UploadForm();
        $uploadImg = new UploadForm();

        if (Yii::$app->request->isPost) {
            $uploadFile->file = UploadedFile::getInstance($uploadFile, 'file');
            $uploadImg->img = UploadedFile::getInstance($uploadImg, 'img');

            if ($uploadFile->file && $uploadFile->validate()) {
                $uploadFile->file->saveAs('uploads/' . Yii::$app->translater->translit($uploadFile->file->baseName) . '.' .$uploadFile->file->extension);

            }
            elseif($uploadImg->img && $uploadImg->validate()) {
                $uploadImg->img->saveAs('uploads/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension);

            }
            else { print_r($uploadFile->getErrors()); }
        }

        //var_dump($uploadImg); exit;
        if ($model->load(Yii::$app->request->post())) {
            $model->text = Yii::$app->request->post('Articles')['text'];
            $model->title = Yii::$app->request->post('Articles')['title'];
            $model->alias = TranslateHelper::translit(Yii::$app->request->post('Articles')['title']);
            $model->site_id = Yii::$app->request->post('Articles')['site_id'];
            $model->cat_id = Yii::$app->request->post('Articles')['cat_id'];
            if(isset($uploadFile->file))
                $model->audio = Url::base().'uploads/' . Yii::$app->translater->translit($uploadFile->file->baseName) . '.' .$uploadFile->file->extension;

            if(isset($uploadImg->img))
                $model->img = Url::base().'uploads/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension;
            $model->save(false);

            $articles = Articles::find();
            $dataProvider = new ActiveDataProvider([
                'query' => $articles,
            ]);

            return $this->render('index', ['articles' => $dataProvider]);
        } else {

            return $this->render('_form', [
                'model' => $model,
                'uploadFile' => $uploadFile,
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
     * Добавляем страницу контента
     *
     */
    //@TODO добавление страницы из списка страниц контента
    //@TODO при добавлении страницы выводить название контента
    public function actionAddpage($id){

        $artContent = new ArticlesContent;

        $upload = new UploadForm();

        if (Yii::$app->request->isPost) {
            $upload->file = UploadedFile::getInstance($upload, 'file');

            if ($upload->file && $upload->validate()) {
                $upload->file->saveAs('uploads/' . Yii::$app->translater->translit($upload->file->baseName) . '.' .$upload->file->extension);

            }
            else { print_r($upload->getErrors()); }
        }

        if ($artContent->load(Yii::$app->request->post())) {
            $artContent->body = Yii::$app->request->post('ArticlesContent')['body'];
            $artContent->minititle = Yii::$app->request->post('ArticlesContent')['minititle'];
            $artContent->articles_id = $id;
            if(isset($upload->file))$artContent->audio = Url::base().'uploads/' . Yii::$app->translater->translit($upload->file->baseName) . '.' .$upload->file->extension;
            else $artContent->audio = '';

            $artContent->save();


            $content = ArticlesContent::find()
                ->where(['articles_id' => $id]);

            $dataCont = new ActiveDataProvider([
                'query' => $content,

            ]);

            return $this->render('pages', [
                'content' => $dataCont,
                'model' => $artContent,


            ]);

        } else {

            return $this->render('page_form', [
                'model' => $artContent,
                'upload' => $upload,
            ]);
        }

    }

    /**
     * Обновляет страницу
     * @param $id
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionUpdatepage($id) {

        $artContent = $this->loadModelcontent($id);
        $artId = $artContent->articles_id;
        $upload = new UploadForm();
        //var_dump($upload); exit;
        if (Yii::$app->request->isPost) {
            $upload->file = UploadedFile::getInstance($upload, 'file');

            if ($upload->file && $upload->validate()) {
                $upload->file->saveAs('uploads/' . Yii::$app->translater->translit($upload->file->baseName) . '.' .$upload->file->extension);

            }
            else { print_r($upload->getErrors()); }
        }


        if ($artContent->load(Yii::$app->request->post())) {
            $artContent->body = Yii::$app->request->post('ArticlesContent')['body'];
            $artContent->minititle = Yii::$app->request->post('ArticlesContent')['minititle'];
            $artContent->articles_id = $artId;
            $artContent->audio = Url::base().'uploads/' . Yii::$app->translater->translit($upload->file->baseName) . '.' .$upload->file->extension;

            $artContent->save();

            $content = ArticlesContent::find()
                ->where(['articles_id' => $artId]);

            $dataCont = new ActiveDataProvider([
                'query' => $content,

            ]);

            return $this->render('pages', [
                'content' => $dataCont,
                'model' => $artContent,

            ]);

        } else {

            return $this->render('page_form', [
                'model' => $artContent,
                'upload' => $upload,
            ]);
        }
    }

    /**
     * Удаление страницы контента
     * @param $id
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionDeletepage($id)
    {
        $model = $this->loadModelcontent($id);
        $artId = $model->articles_id;

        if ($this->loadModelcontent($id)->delete()) {


            $content = ArticlesContent::find()
                ->where(['articles_id' => $artId]);

            $dataCont = new ActiveDataProvider([
                'query' => $content,

            ]);

            return $this->render('pages', [
                'content' => $dataCont,

            ]);
        } else {
            throw new \yii\web\HttpException(404, 'Cant delete record.');
        };


    }


    /**
     * Показывает страницы контента
     * @param $id
     * @return string
     */
    public function actionPages($id) {
        $content = ArticlesContent::find()
            ->where(['articles_id' => $id]);

        $dataCont = new ActiveDataProvider([
            'query' => $content,

        ]);

        return $this->render('pages', [
            'content' => $dataCont,

        ]);

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

    /**
     * Возвращает модель страницы контента
     * @param $id
     * @return null|static
     * @throws \yii\web\HttpException
     */
    public function loadModelcontent($id)
    {

        $model = ArticlesContent::findOne($id);

        if ($model === null)
            throw new \yii\web\HttpException(404, 'The requested page does not exist.');
        return $model;
    }



}

