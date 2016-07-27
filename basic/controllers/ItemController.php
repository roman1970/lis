<?php
namespace app\controllers;

use app\components\BackEndController;
use app\models\Items;
use app\models\Playlist;
use app\models\Tag;
use app\models\UploadForm;
use yii\data\ActiveDataProvider;
use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;

class ItemController extends BackEndController
{
    public $layout = 'admin';
    const STATUS_CREATE = 0;
    const STATUS_UPDATE = 1;

    public function actionIndex()
    {
        $items = Items::find()->orderBy('id DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $items,
        ]);

        return $this->render('index', ['items' => $dataProvider]);
    }

    public function actionCreate()
    {
        $this->layout = 'admin';

        $model = new Items();

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
            $model->text = Yii::$app->request->post('Items')['text'];
            $model->tags = Yii::$app->request->post('Items')['tags'];
            $model->title = Yii::$app->request->post('Items')['title'];
            $model->audio_link = Yii::$app->request->post('Items')['audio_link'];
            $model->play_status = 1;


            if(isset(Yii::$app->request->post('Items')['source_id']))$model->source_id = Yii::$app->request->post('Items')['source_id'];
            else $model->source_id = 2;
            if(isset($uploadFile->file))
                $model->audio = Url::base().'uploads/' . Yii::$app->translater->translit($uploadFile->file->baseName) . '.' .$uploadFile->file->extension;

            if(isset($uploadImg->img))
                $model->img = Url::base().'uploads/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension;
            $model->save(false);
            //var_dump($model->id); exit;
            Tag::addTags($model->tags, $model->id);


            return $this->redirect(Url::toRoute('item/index'));

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

        if ($model->load(Yii::$app->request->post())) {
            $model->text = Yii::$app->request->post('Items')['text'];
            $model->tags = Yii::$app->request->post('Items')['tags'];
            $model->title = Yii::$app->request->post('Items')['title'];
            $model->audio_link = Yii::$app->request->post('Items')['audio_link'];
            $model->play_status = 1;

            Tag::addTags($model->tags, $id);


            if(isset(Yii::$app->request->post('Items')['source_id']))$model->source_id = Yii::$app->request->post('Items')['source_id'];
            else $model->source_id = 2;
            if(isset($uploadFile->file))
                $model->audio = Url::base().'uploads/' . Yii::$app->translater->translit($uploadFile->file->baseName) . '.' .$uploadFile->file->extension;

            if(isset($uploadImg->img))
                $model->img = Url::base().'uploads/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension;
            $model->save(false);


            return $this->redirect(Url::toRoute('item/index'));

        } else {

            return $this->render('_form', [
                'model' => $model,
                'uploadFile' => $uploadFile,
                'uploadImg' => $uploadImg,

            ]);
        }

    }

    /**
     * Удаляет айтем
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\web\HttpException
     */
    public function actionDelete($id)
    {

        if ($model = $this->loadModel($id)->delete()) {
            $items = Items::find();
            $dataProvider = new ActiveDataProvider([
                'query' => $items,
            ]);

            return $this->render('index', ['items' => $dataProvider]);
        } else {
            throw new \yii\web\HttpException(404, 'Cant delete record.');
        };

    }

    /**
     * Список без аудио
     * @return string
     */
    public function actionListNoAudio(){
        $items = Items::find()->where(['audio_link' => '']);

        $dataProvider = new ActiveDataProvider([
            'query' => $items,
        ]);

        return $this->render('index', ['items' => $dataProvider]);
    }
    
    
    public function actionAddPlaylist(){
        $playlist = new Playlist();

        if ($playlist->load(Yii::$app->request->post())) {
            $playlist->name = Yii::$app->request->post('Playlist')['name'];
            $playlist->save();

            return $this->redirect(Url::toRoute('item/index'));

        } else {

            return $this->render('new_playlist', ['playlist' => $playlist]);
        }

        
    }
    
    public function actionChoosePlaylist(){
        $playlists = Playlist::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $playlists,
        ]);


        return $this->render('playlists', ['playlists' => $dataProvider]);
    }
    
    public function actionFormPlaylist($id){
        
        
        $items = Items::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $items,
        ]);

        $this_items = Items::find()->where(['play_status' => $id]);
        $dataProvider2 = new ActiveDataProvider([
            'query' => $this_items,
        ]);

        //var_dump($id); exit;


        return $this->render('playlist', ['items' => $dataProvider, 'new_items' => $dataProvider2, 'pl' => $id]);
    }

    public function actionPlAdd($id, $pl){

        //var_dump(Yii::$app->getRequest()); exit;

        $model = $this->loadModel($id);
        $model->play_status = $pl;
        $model->update();

        //var_dump(Items::$current_playlist); exit;

        $items = Items::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $items,
        ]);

        $this_items = Items::find()->where(['play_status' => $pl]);
        $dataProvider2 = new ActiveDataProvider([
            'query' => $this_items,
        ]);

        return $this->render('playlist', ['items' => $dataProvider, 'new_items' => $dataProvider2]);

    }
    

    public function loadModel($id)
    {

        $model = Items::findOne($id);

        if ($model === null)
            throw new \yii\web\HttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
    


}