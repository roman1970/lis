<?php

namespace app\modules\weather\controllers;

use app\components\FrontEndController;
use Yii;
//use yii\web\Controller;
use app\modules\weather\models\Weather;


class DefaultController extends FrontEndController
{


    public function actionIndex()
    {
        $modelWeather = new Weather();
        $last = $modelWeather::find()
            ->where(['city_id' => 1938])
            ->limit(1)
            ->all();

        return $this->render('index', [
            'model' => $last,
        ]);
    }

}