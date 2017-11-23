<?php
namespace app\controllers;

use app\components\BackEndController;
use app\models\Categories;
use app\models\Category;
use app\models\Items;
use app\models\ItemsSearch;
use app\models\ItemsQueSearch;
use app\models\MarkUser;
use app\models\Playlist;
use app\models\Source;
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
    public static $curr_playlist;

    public function actionIndex()
    {
       // $items = Items::find()->orderBy('id DESC');
        $searchModel = new ItemsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        /*
        $dataProvider = new ActiveDataProvider([
            'query' => $items,

        ]);
        */

        return $this->render('index', ['items' => $dataProvider, 'searchModel' => $searchModel]);
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
            $model->cens = Yii::$app->request->post('Items')['cens'];
            $model->cens = Yii::$app->request->post('Items')['published'];
            //$model->cat_id = Yii::$app->request->post('Items')['cat_id'];

            if(Categories::find()->where(['title' => Yii::$app->request->post('Items')['cat_title']])->one()){

                $model->cat_id = Categories::find()->where(['title' => Yii::$app->request->post('Items')['cat_title']])->one()->id;
            }
            
            $model->audio_link = Yii::$app->request->post('Items')['audio_link'];
            $model->in_work_prim = Yii::$app->request->post('Items')['in_work_prim'];
            $model->play_status = 1;


            //if(isset(Yii::$app->request->post('Items')['source_id']))$model->source_id = Yii::$app->request->post('Items')['source_id'];
            //else $model->source_id = 2;

            if(Source::find()->where(['title' => Yii::$app->request->post('Items')['source_title']])->one()){

                $model->source_id = Source::find()->where(['title' => Yii::$app->request->post('Items')['source_title']])->one()->id;
            }
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

        $model->cat_title = Categories::findOne($model->cat_id)->title;
        $model->source_title = Source::findOne($model->source_id)->title;

       // var_dump($model->source_title); exit;

        if (Yii::$app->request->isPost) {
            $uploadFile->file = UploadedFile::getInstance($uploadFile, 'file');
            $uploadImg->img = UploadedFile::getInstance($uploadImg, 'img');

            //var_dump($uploadFile); exit;

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
            $model->cens = Yii::$app->request->post('Items')['cens'];
            $model->cens = Yii::$app->request->post('Items')['published'];
            //$model->cat_id = Yii::$app->request->post('Items')['cat_id'];
            
            if(Categories::find()->where(['title' => Yii::$app->request->post('Items')['cat_title']])->one()){

                $model->cat_id = Categories::find()->where(['title' => Yii::$app->request->post('Items')['cat_title']])->one()->id;
            }
            
            $model->audio_link = Yii::$app->request->post('Items')['audio_link'];
            $model->in_work_prim = Yii::$app->request->post('Items')['in_work_prim'];
            //$model->play_status = 1;

            Tag::addTags($model->tags, $id);


            //if(isset(Yii::$app->request->post('Items')['source_id']))$model->source_id = Yii::$app->request->post('Items')['source_id'];
            //else $model->source_id = 2;

            if(Source::find()->where(['title' => Yii::$app->request->post('Items')['source_title']])->one()){

                $model->source_id = Source::find()->where(['title' => Yii::$app->request->post('Items')['source_title']])->one()->id;
            }
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
        }

    }

    /**
     * Список без аудио
     * @return string
     */
    public function actionListNoAudio(){
        $items = Items::find()
            ->where(['audio_link' => ''])
            //->andWhere("source_id <> 2 and source_id <> 43 and cat_id <> 53")
            ->orderBy(['rand()' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $items,
        ]);

        return $this->render('list', ['items' => $dataProvider]);
    }

    /**
     * КВН без аудио
     * @return string
     */
    public function actionListKvnNoAudio(){
        $items = Items::find()
            ->where("audio_link is NULL OR audio_link = ''")
            ->andWhere("source_id = 21")
            ->orderBy(['rand()' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $items,
        ]);

        return $this->render('list', ['items' => $dataProvider]);
    }

    /**
     * Рабочий список
     * @return string
     */
    public function actionInWork(){
        $items = Items::find()->where("in_work_prim <> '' ");

        $dataProvider = new ActiveDataProvider([
            'query' => $items,
        ]);

        return $this->render('list', ['items' => $dataProvider]);
    }
    
    public function actionShowRepertoire(){
        $items = Items::find()->where("cat_id = 90 or cat_id = 89");

        $dataProvider = new ActiveDataProvider([
            'query' => $items,
        ]);

        return $this->render('list', ['items' => $dataProvider]);
    }

    /**
     * Добавление плейлиста
     * @return string|\yii\web\Response
     */
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

    /**
     * Формирование плейлиста
     * @param $id
     * @return string
     */
    public function actionFormPlaylist($id){
        
        if($id == 7) {
            $searchModel = new ItemsQueSearch();
            $dataProvider = $searchModel->searchRepertoire(Yii::$app->request->queryParams);

            $this_items = Items::find()->where(['play_status' => $id])->orderBy('radio_que');
            $dataProvider2 = new ActiveDataProvider([
                'query' => $this_items,
            ]);
        }
        else {
            $searchModel = new ItemsQueSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            $this_items = Items::find()->where(['play_status' => $id])->orderBy('radio_que');
            $dataProvider2 = new ActiveDataProvider([
                'query' => $this_items,
            ]);
        }


        return $this->render('playlist', ['items' => $dataProvider, 'new_items' => $dataProvider2, 'pl' => $id, 'searchModel' => $searchModel]);
    }

    /**
     * Добавление в плейлист
     * @param $id
     * @param $pl
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionPlAdd($id, $pl){
        

        $model = $this->loadModel($id);
        $model->play_status = $pl;
        $model->update(false);

        if($pl == 7) {
            $searchModel = new ItemsQueSearch();
            $dataProvider = $searchModel->searchRepertoire(Yii::$app->request->queryParams);

            $this_items = Items::find()->where(['play_status' => 7])->orderBy('radio_que');
            $dataProvider2 = new ActiveDataProvider([
                'query' => $this_items,
            ]);
        }
        else {
            $searchModel = new ItemsQueSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            $this_items = Items::find()->where(['play_status' => $pl])->orderBy('radio_que');
            $dataProvider2 = new ActiveDataProvider([
                'query' => $this_items,
            ]);
        }




        return $this->render('playlist', ['items' => $dataProvider, 'new_items' => $dataProvider2,  'searchModel' => $searchModel, 'pl' => $pl]);

    }

    /**
     * Удаление из плейлиста
     * @param $id
     * @param $pl
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionPlRemove($id, $pl){
        $model = $this->loadModel($id);
        $model->play_status = 1;
        $model->update(false);

        $searchModel = new ItemsQueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this_items = Items::find()->where(['play_status' => $pl])->orderBy('radio_que');
        $dataProvider2 = new ActiveDataProvider([
            'query' => $this_items,
        ]);

        return $this->render('playlist', ['items' => $dataProvider, 'new_items' => $dataProvider2,  'searchModel' => $searchModel,  'pl' => $pl]);
        
    }

    public function actionChangeq(){
        $que = 100;
        if(Yii::$app->getRequest()->getQueryParam('que') !== null && Yii::$app->getRequest()->getQueryParam('id') !== null) {
            $que = Yii::$app->getRequest()->getQueryParam('que');
            $id = Yii::$app->getRequest()->getQueryParam('id');
            $model = $this->loadModel($id);
            $model->radio_que = $que;
            $model->update(false);
        }
        
        echo $que;
    }
    

    public function loadModel($id)
    {

        $model = Items::findOne($id);

        if ($model === null)
            throw new \yii\web\HttpException(404, 'The requested page does not exist.');
        return $model;
    }

    
    function actionShow($id){
        //return 45;
        if ($id) {
            $this->layout = 'rncont';
            $item = Items::findOne((int)$id);
            return $this->render('item_by_id', ['rec' => $item]);
        }
        else return 'ups';

    }

    public function actionEditItemText(){
        return 5;
        //$request = Yii::$app->request;
        //return $request->post('edited');
        //return var_dump(Yii::$app->getRequest()->getQueryParam('user'));
        if(Yii::$app->getRequest()->getQueryParam('user')) {

            $user = MarkUser::findOne(Yii::$app->getRequest()->getQueryParam('user'));

            if (!$user) return 'Доступ запрещен!';

            if(Yii::$app->getRequest()->getQueryParam('edited') && Yii::$app->getRequest()->getQueryParam('id')){
                $item = Items::findOne((int)Yii::$app->getRequest()->getQueryParam('id'));
                $item->text = Yii::$app->getRequest()->getQueryParam('edited');
                if($item->update(false)) return 'Изменено!';
                else return 'Измена!';
            }
            else return 'Ошибка сохранения';
        }

        else return 'Ошибка доступа';
    }
    
    


}