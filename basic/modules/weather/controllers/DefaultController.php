<?php

namespace app\modules\weather\controllers;

use app\components\FrontEndController;
use Yii;
//use yii\web\Controller;
use app\modules\weather\models\Weather;


class DefaultController extends FrontEndController
{


    /**
     * @return string
     */
    public function actionIndex()
    {
        $modelWeather = new Weather();
        $last = $modelWeather::find()
            ->where(['city_id' => 1938, 'chas' => 10])
            ->all();

        return $this->render('index', [
            'model' => $last,
        ]);
    }

    public function actionTruee($id){
        return $id;
    }


}