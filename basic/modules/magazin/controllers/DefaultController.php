<?php
namespace app\modules\magazin\controllers;

use app\components\FrontEndController;
use app\models\Products;
use Yii;
use app\models\Categories;
use yii\data\Pagination;


class DefaultController extends FrontEndController
{

    public function actionIndex()
    {
        $products = Products::find()->all();

        return $this->render('index', ['products' => $products]);
    }
}