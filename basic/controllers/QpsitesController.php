<?php

namespace app\controllers;

use app\components\BackEndController;
use app\models\Qpsites;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

class QpsitesController extends BackEndController
{
    public function actionIndex()
    {

        $sites = Qpsites::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $sites,
        ]);

        return $this->render('index', ['sites' => $dataProvider]);

    }

    public function actionCreate()
    {
        $model = new Qpsites();


        if ($model->load(Yii::$app->request->post())) {
            //$userModel = Yii::$app->user->identity; //так получаем модель Юзера

            $model->title = Yii::$app->request->post('Qpsites')['title'];
            $model->url = Yii::$app->request->post('Qpsites')['url'];
            $model->theme = Yii::$app->request->post('Qpsites')['theme'];
            $model->user_id = Yii::$app->user->identity->getId();

            //$model->save(false);

            return $this->render('code', ['model' => $model]);

            //return $this->redirect(Url::toRoute('qpsites/index'));

        } else {

            return $this->render('_form', [
                'model' => $model,

            ]);
        }

    }

}
