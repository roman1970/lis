<?php
namespace app\controllers;

use app\components\BackEndController;
use app\models\Event;
use app\models\UploadForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\UploadedFile;
use Yii;

class EventController extends BackEndController
{
    public function actionIndex()
    {
        $events = Event::find()->orderBy('id DESC')->limit(30);
        $dataProvider = new ActiveDataProvider([
            'query' => $events,
        ]);


        return $this->render('index', ['events' => $dataProvider]);
    }


    /**
     * Добавление картинки
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\web\HttpException
     */
    public function actionAddImg($id){

        $model = $this->loadModel($id);
        $uploadImg = new UploadForm();


        if (Yii::$app->request->isPost) {

            $uploadImg->img = UploadedFile::getInstance($uploadImg, 'img');

            if($uploadImg->img && $uploadImg->validate()) {
                $uploadImg->img->saveAs('uploads/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension);

            }
            else { print_r($uploadImg->getErrors()); }

            //var_dump($uploadImg); exit;
            if(isset($uploadImg->img)) {
                $model->img = Url::base().'uploads/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension;
                $model->update(false);

                return $this->redirect(Url::toRoute('event/index'));
            }
            
        
        }


        return $this->render('_form', [
            'model' => $model,
            'uploadImg' => $uploadImg,
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

        $model = Event::findOne($id);

        if ($model === null)
            throw new \yii\web\HttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
}