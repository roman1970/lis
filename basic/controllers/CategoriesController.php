<?php
namespace app\controllers;

use app\components\BackEndController;
use app\models\Categories;

class CategoriesController extends BackEndController
{

    public function actionIndex()
    {
        $cats = Categories::find()->all();
        return $this->render('index', ['cats' => $cats]);
    }

}