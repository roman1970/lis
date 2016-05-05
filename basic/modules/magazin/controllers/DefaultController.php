<?php
namespace app\modules\magazin\controllers;

use app\components\FrontEndController;
use app\models\Products;
use Yii;
use app\models\Categories;
use yii\data\Pagination;
use yii\web\Session;


class DefaultController extends FrontEndController
{

    public function actionIndex()
    {
        $products = Products::find()->all();

        return $this->render('index', ['products' => $products]);
    }

    /**
     * Добавление в корзину через сессию
     * @param $id
     * @return \yii\web\Response
     */
    public function actionAdd($id){

        Yii::$app->cart->add($id);
        return $this->redirect(['index']);
    }
}