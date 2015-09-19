<?php
namespace app\controllers;

use app\components\BackEndController;
use app\models\Categories;
use Yii;

class CategoriesController extends BackEndController
{
    public $layout = 'admin';

    public function actionIndex()
    {
        $cats = Categories::find()->all();
        return $this->render('index', ['cats' => $cats]);
    }

    public function actionCreate()
    {

        $model = new Categories();
        if ($model->load(Yii::$app->request->post())) {
           // var_dump($model); exit;
            $countries = new Categories(['name' => 'Countries']);
            $countries->load(Yii::$app->request->post());
            $countries->makeRoot();
            $russia = new Categories(['name' => 'Russia']);
            $russia->prependTo($countries);

            return $this->goBack();
        } else {
            return $this->render('_form', [
                'model' => $model,
            ]);
        }



    }

}