<?php
namespace app\modules\magazin\controllers;

use app\components\FrontEndController;
use Yii;
use app\models\Categories;
use yii\data\Pagination;


class DefaultController extends FrontEndController
{

    public function actionIndex()
    {
        return $this->render('index');
    }
}