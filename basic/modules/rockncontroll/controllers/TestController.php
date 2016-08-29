<?php

namespace app\modules\rockncontroll\controllers;


use app\components\FrontEndController;

use app\models\Estest;
use Yii;

class TestController extends FrontEndController
{

    /**
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index');

    }

    public function actionTestes()
    {
        $tests = Estest::find()->all();

        return $this->renderPartial('index', ['tests' => $tests]);


    }
}
