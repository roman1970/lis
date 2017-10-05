<?php
namespace app\controllers;

use app\models\DeutschItem;
use app\models\DeutschItemSearch;
use yii\data\ActiveDataProvider;
use Yii;
use yii\helpers\Url;
use app\components\BackEndController;


class DeutschitemController extends BackEndController
{

    public $layout = 'admin';

    public function actionIndex()
    {
        $searchModel = new DeutschItemSearch();
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

        $model = new DeutschItem();

        if ($model->load(Yii::$app->request->post())) {

            $word = Yii::$app->request->post('DeutschItem')['d_word'];
            $phrase = Yii::$app->request->post('DeutschItem')['d_phrase'];

            $model->d_word = $word;
            $model->d_phrase = $phrase;

            $model->d_word_translation = Yii::$app->request->post('DeutschItem')['d_word_translation'];
           
            $model->d_phrase_translation = Yii::$app->request->post('DeutschItem')['d_phrase_translation'];

            $model->d_word_transcription = Yii::$app->request->post('DeutschItem')['d_word_transcription'];
            
            $model->d_phrase_transcription = Yii::$app->request->post('DeutschItem')['d_phrase_transcription'];

            /*генерация слова и ссылки*/

            $word_for_file = str_replace(' ', '_', $word);
            $word_for_file = str_replace('?', '_', $word_for_file);
            $cmd = "espeak -v mb-de4 '".$word."' -s 100 -w /home/romanych/Музыка/Thoughts_and_klassik/deutsch/".$word_for_file.".wav";
            shell_exec($cmd);

            $model->audio_link = "deutsch/".$word_for_file.".wav";

            /*генерация фразы и ссылки*/

            $phrase_for_file = str_replace(' ', '_', $phrase);
            $phrase_for_file = str_replace('?', '_', $phrase_for_file);
            $phrase_for_file = str_replace('.', '_', $phrase_for_file);
            $cmd = "espeak -v mb-de4 '".$phrase."' -s 100 -w /home/romanych/Музыка/Thoughts_and_klassik/deutsch/".$phrase_for_file.".wav";
            shell_exec($cmd);

            $model->audio_phrase_link = "deutsch/".$phrase_for_file.".wav";


            if($model->save(false))
                return $this->redirect(Url::toRoute('deutschitem/index'));
            else return $this->render('_form', [
                'model' => $model,
            ]);

        } else {

            return $this->render('_form', [
                'model' => $model,
            ]);
        }

    }

    public function actionUpdate($id){
        $model = $this->loadModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->d_word = Yii::$app->request->post('DeutschItem')['d_word'];
           
            $model->d_phrase = Yii::$app->request->post('DeutschItem')['d_phrase'];

            $model->d_word_translation = Yii::$app->request->post('DeutschItem')['d_word_translation'];
           
            $model->d_phrase_translation = Yii::$app->request->post('DeutschItem')['d_phrase_translation'];

            $model->d_word_transcription = Yii::$app->request->post('DeutschItem')['d_word_transcription'];
            
            $model->d_phrase_transcription = Yii::$app->request->post('DeutschItem')['d_phrase_transcription'];


            if($model->update(false))
                return $this->redirect(Url::toRoute('deutschitem/index'));
            else return $this->render('_form', [
                'model' => $model,
            ]);

        } else {

            return $this->render('_form', [
                'model' => $model,
            ]);
        }

    }

    public function loadModel($id)
    {

        $model = DeutschItem::findOne($id);

        if ($model === null)
            throw new \yii\web\HttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
    
    
}