<?php

namespace app\modules\rockncontroll\controllers;


use app\components\FrontEndController;
use app\models\DiaryDish;
use Yii;
use app\models\Categories;
use yii\data\Pagination;

use app\models\Articles;


class DefaultController extends FrontEndController
{

    /**
     * @return string
     */
    public function actionIndex(){
        return $this->render('index');

    }
    
    public function actionEat(){
        return $this->render('eat');
    }

    public function actionDishes(){
        $res = [];
      
        $m = DiaryDish::find()
            ->all();
        foreach ($m as $h){
           
          $res[] = $h->name;
           
        }

        return  json_encode($res);
    }

}